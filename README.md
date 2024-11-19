# Production calendar

## Описание:

Библиотека production-calendar позволяет получать данные о производственном календаре из сервиса
[production-calendar.ru](https://production-calendar.ru/).

## Использование:

Чтобы использовать библиотеку, необходимо установить её с помощью Composer:
```php
composer require shahruslan/production-calendar
```
Далее надо будет подключить какой-нибудь PSR-18 совместимый
[http-client](https://packagist.org/providers/psr/http-client-implementation). Этот клиент подключается автоматически,
но при желании вы можете его сконфигурировать и передать в конструктор. И в заключении получаем
[токен](https://production-calendar.ru/token) для работы с API. Чтобы его получить, достаточно указать свой email, на
который придет письмо с токеном. Затем можно использовать класс `Calendar` для получения данных о производственном
календаре:
```php
use Shahruslan\ProductionCalendar\Calendar;

$calendar = new Calendar('your-token');

// Получение календаря на весь год
$calendarForYear = $calendar->getPeriodForYear(2024);

// Получение календаря на определённый месяц
$calendarForMonth = $calendar->getPeriodForMonth(2024, 1);

// Получение календаря на определённый день
$calendarForDay = $calendar->getPeriodForDay(new DateTime('2024-01-01'));
```

### Методы класса `Calendar`

- `getPeriodForYear(int $year): Period` - Получение календаря на весь год;
- `getPeriodForQuarter(int $year, int $quarter): Period` - Получение календаря на определённый квартал;
- `getPeriodForMonth(int $year, int $month): Period` - Получение календаря на определённый месяц;
- `getPeriodForDay(DateTimeInterface $date): Period` - Получение календаря на определённый день;
- `getPeriod(string $period): Period` - Получение календаря на произвольный период(не более года).

Каждый метод возвращает объект класса `Period`, содержащий данные о производственном календаре.

### Класс `Period`

Класс `Period` представляет собой объект, содержащий данные о производственном календаре. В свойстве `days` массив
объектов типа `Day` со свойствами:
- `date` - текущий день;
- `type` - тип дня(праздничный, рабочий, выходной и тд);
- `weekDay` - день недели;
- `workingHours` - количество рабочих часов.
- `isProject` - находится ли этот день в проекте закона и еще не утвержден.

Свойство `statistic` отображает ряд статистических данных для задаваемого периода:
- `calendarDays` – количество календарных дней в периоде;
- `calendarDaysWithoutHolidays` - количество календарных дней в периоде без учета праздничных дней (полезный показатель
для расчета продолжительности отпуска работника);
- `workDays` – количество рабочих дней в периоде;
- `weekends` – количество выходных дней в периоде (без учета праздничных);
- `holidays` – количество праздничных дней в периоде;
- `shortenedWorkingDays` – количество сокращённых рабочих дней в периоде;
- `workingHours` – количество рабочего времени за период.

```php
use Shahruslan\ProductionCalendar\Calendar;

$calendar = new Calendar('your-token');
$period = $calendar->getPeriod('07.01.2024-09.01.2024', region: 23);
print_r($period);
```
Output:
```
Shahruslan\ProductionCalendar\Entity\Period Object
(
    [country] => Shahruslan\ProductionCalendar\Entity\Dictionary\Country Object
        (
            [code] => ru
            [text] => Российская Федерация
        )
    [region] => Shahruslan\ProductionCalendar\Entity\Dictionary\Region Object
        (
            [number] => 23
            [text] => Краснодарский край
        )
    [dateStart] => DateTimeImmutable Object
        (
            [date] => 2024-01-07 00:00:00.000000
            [timezone_type] => 3
            [timezone] => UTC
        )
    [dateEnd] => DateTimeImmutable Object
        (
            [date] => 2024-01-09 00:00:00.000000
            [timezone_type] => 3
            [timezone] => UTC
        )
    [workWeekType] => 5-и дневная рабочая неделя
    [period] => Произвольный период
    [days] => Array
        (
            [0] => Shahruslan\ProductionCalendar\Entity\Day Object
                (
                    [date] => DateTimeImmutable Object
                        (
                            [date] => 2024-01-07 00:00:00.000000
                            [timezone_type] => 3
                            [timezone] => UTC
                        )
                    [type] => Shahruslan\ProductionCalendar\Entity\Dictionary\DayType Enum:string
                        (
                            [name] => publicHoliday
                            [value] => Государственный праздник
                        )
                    [weekDay] => Shahruslan\ProductionCalendar\Entity\Dictionary\WeekDay Enum:string
                        (
                            [name] => sunday
                            [value] => вс
                        )
                    [workingHours] => 0
                    [isProject] => 0
                )
            [1] => Shahruslan\ProductionCalendar\Entity\Day Object
                (
                    [date] => DateTimeImmutable Object
                        (
                            [date] => 2024-01-08 00:00:00.000000
                            [timezone_type] => 3
                            [timezone] => UTC
                        )
                    [type] => Shahruslan\ProductionCalendar\Entity\Dictionary\DayType Enum:string
                        (
                            [name] => publicHoliday
                            [value] => Государственный праздник
                        )
                    [weekDay] => Shahruslan\ProductionCalendar\Entity\Dictionary\WeekDay Enum:string
                        (
                            [name] => monday
                            [value] => пн
                        )
                    [workingHours] => 0
                    [isProject] => 0
                )
            [2] => Shahruslan\ProductionCalendar\Entity\Day Object
                (
                    [date] => DateTimeImmutable Object
                        (
                            [date] => 2024-01-09 00:00:00.000000
                            [timezone_type] => 3
                            [timezone] => UTC
                        )
                    [type] => Shahruslan\ProductionCalendar\Entity\Dictionary\DayType Enum:string
                        (
                            [name] => workingDay
                            [value] => Рабочий день
                        )
                    [weekDay] => Shahruslan\ProductionCalendar\Entity\Dictionary\WeekDay Enum:string
                        (
                            [name] => tuesday
                            [value] => вт
                        )
                    [workingHours] => 8
                    [isProject] => 0
                )
        )
    [statistic] => Shahruslan\ProductionCalendar\Entity\Statistic Object
        (
            [calendarDays] => 3
            [calendarDaysWithoutHolidays] => 1
            [workDays] => 1
            [weekends] => 0
            [holidays] => 2
            [shortenedWorkingDays] => 0
            [workingHours] => 8
        )
)
```

## Дополнительные настройки
При необходимости можно получить производственный календарь для конкретного региона. Например, в Краснодарском крае
14 мая 2024 года отмечается Радоница, и этот день объявлен выходным днем:
```php
$calendar = new Shahruslan\ProductionCalendar\Calendar('token');
$data = $calendar->isWorkingDay(new DateTimeImmutable('14.05.2024'));
var_dump($data);
$data = $calendar->setRegion(23)->isWorkingDay(new DateTimeImmutable('14.05.2024'));
var_dump($data);

```

Output:
```shell
bool(true)
bool(false)
```


Помимо региона, еще можно настроить и другие параметры:

```php
new Calendar(
	'token',
	isSixDayWeek: true, // включить учет по 6-ти дневной рабочей неделе
	isWeekendsOfSchrodinger: true, // учитывать ли так называемые нерабочие дни с сохранением заработной платы, которые начали практиковать с 2020 года (В период пандемии COVID-19)
	compact: true, // будут выводиться только особые дни, которые отличаются от обычного календаря
);
```
