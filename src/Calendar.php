<?php

declare(strict_types=1);

namespace Shahruslan\ProductionCalendar;

use DateTimeInterface;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\Exception\HttpException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Shahruslan\ProductionCalendar\Entity\Dictionary\DayType;
use Shahruslan\ProductionCalendar\Entity\Period;
use Shahruslan\ProductionCalendar\Exception\PeriodException;
use Shahruslan\ProductionCalendar\Factory\Factory;
use Shahruslan\ProductionCalendar\Validator\Validator;

/**
 * @api
 */
final class Calendar
{
    private static string $host = 'https://production-calendar.ru';
    private readonly RequestFactoryInterface $requestFactory;
    private readonly ClientInterface $client;
    private readonly Validator $validator;

    public function __construct(
        private readonly string $token,
        private string $country = 'ru',
        private ?int $region = null,
        private bool $isSixDayWeek = false,
        private bool $isWeekendsOfSchrodinger = false,
        private bool $isCompact = false,
        RequestFactoryInterface $requestFactory = null,
        ClientInterface $client = null,
    ) {
        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->client = $client ?: new PluginClient(
            Psr18ClientDiscovery::find(),
            [new RedirectPlugin()],
        );
        $this->validator = new Validator();
    }

    /**
     * @throws ClientExceptionInterface
     */
    private function request(string $url): string
    {
        $url = self::$host . $url;
        $request = $this->requestFactory->createRequest('GET', $url);
        $response = $this->client->sendRequest($request);

        if ($response->getStatusCode() >= 400) {
            throw new HttpException('Error executing request', $request, $response);
        }

        return $response->getBody()->getContents();
    }

    /**
     * Установить буквенный код страны для получения календаря.
     * В данный момент поддерживаются только ru и kz.
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Позволяет задать регион РФ (в ряде регионов присутствуют свои региональные праздники, для которых
     * производственный календарь отличается). В качестве номера региона задается однозначные или двузначные коды ГИБДД.
     * Трехзначные не поддерживаются.
     */
    public function setRegion(?int $region): self
    {
        $this->region = $region;
        return $this;
    }

    /**
     * Настройка расчета по 6-ти дневной рабочей недели. По умолчанию расчет идет по 5-дневной недели.
     */
    public function setIsSixDayWeek(bool $isSixDayWeek): self
    {
        $this->isSixDayWeek = $isSixDayWeek;
        return $this;
    }

    /**
     * Параметр показывает нужно ли учитывать так называемые нерабочие дни с сохранением заработной платы, которые
     * начали практиковать с 2020 года (В период пандемии COVID-19). В народе эти дни прозвали "выходные дни,
     * которые как бы есть, и одновременно которых как бы нет". Weekends of the Schrodinger. Так называемая отсылка к
     * всем известному коту Шредингера. По умолчанию параметр равен false, то есть подобные выходные не учитываются.
     */
    public function setIsWeekendsOfSchrodinger(bool $isWeekendsOfSchrodinger): self
    {
        $this->isWeekendsOfSchrodinger = $isWeekendsOfSchrodinger;
        return $this;
    }

    /**
     * Если задать данному параметру значение true, то результат будет выдаваться в сокращенном формате, только особые
     * дни, которые отличаются от обычного календаря. По умолчанию этот параметр равен false и календарь выдает все
     * сутки заданного периода.
     */
    public function setIsCompact(bool $isCompact): self
    {
        $this->isCompact = $isCompact;
        return $this;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws PeriodException
     */
    public function getPeriod(string $period): Period
    {
        $weekType = $this->isSixDayWeek ? 6 : 5;
        $wsch = $this->isWeekendsOfSchrodinger ? '1' : '0';
        $isCompact = $this->isCompact ? '1' : '0';

        $url = sprintf(
            '/get-period/%s/%s/%s/json?week_type=%d&wsch=%s&compact=%s',
            $this->token,
            $this->country,
            $period,
            $weekType,
            $wsch,
            $isCompact,
        );

        if ($this->region !== null) {
            $region = str_pad("$this->region", 2, '0', STR_PAD_LEFT);
            $url .= "&region=$region";
        }

        $content = $this->request($url);
        $data = json_decode($content);

        if ($data->status === 'error') {
            throw new PeriodException($data->message);
        }

        return Factory::createPeriod($data);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws PeriodException
     */
    public function getPeriodForYear(int $year): Period
    {
        $this->validator->validateYear($year);
        return $this->getPeriod("$year");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws PeriodException
     */
    public function getPeriodForQuarter(int $year, int $quarter): Period
    {
        $this->validator->validateYear($year);
        $this->validator->validateQuarter($quarter);
        return $this->getPeriod("Q$quarter$year");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws PeriodException
     */
    public function getPeriodForMonth(int $year, int $month): Period
    {
        $this->validator->validateYear($year);
        $this->validator->validateMonth($month);
        $month = str_pad("$month", 2, '0', STR_PAD_LEFT);
        return $this->getPeriod("$month-$year");
    }

    /**
     * @throws ClientExceptionInterface
     * @throws PeriodException
     */
    public function getPeriodForDay(DateTimeInterface $date): Period
    {
        return $this->getPeriod($date->format('d.m.Y'));
    }

    /**
     * @throws PeriodException
     * @throws ClientExceptionInterface
     */
    public function getDay(DateTimeInterface $date): Entity\Day
    {
        $period = $this->getPeriodForDay($date);
        return $period->days[0];
    }

    /**
     * @throws PeriodException
     * @throws ClientExceptionInterface
     */
    public function isWorkingDay(DateTimeInterface $date): bool
    {
        $day = $this->getDay($date);
        return $day->type === DayType::workingDay || $day->type === DayType::shortenedWorkingDay;
    }

    /**
     * @throws PeriodException
     * @throws ClientExceptionInterface
     */
    public function isHoliday(DateTimeInterface $date): bool
    {
        $day = $this->getDay($date);
        return $day->type === DayType::publicHoliday || $day->type === DayType::regionalHoliday;
    }
}
