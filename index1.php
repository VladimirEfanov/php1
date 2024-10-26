<?php

function generateWorkSchedule(int $year, int $startMonth, int $numberOfMonths): void
{
    // Массив месяцы
    $months = [
1 => 'Январь',
2 => 'Февраль',
3 => 'Март',
4 => 'Апрель',
5 => 'Май',
6 => 'Июнь',
7 => 'Июль',
8 => 'Август',
9 => 'Сентябрь',
10 => 'Октябрь',
11 => 'Ноябрь',
12 => 'Декабрь'
    ];

    // Переменная для текущего рабочего дня 
    $currentWorkDay = 1;

    // Расписание для месяцев
    for ($monthOffset = 0; $monthOffset < $numberOfMonths; $monthOffset++) {
        $currentMonth = ($startMonth + $monthOffset - 1) % 12 + 1; // Месяцы с 1 по 12
        $currentYear = $year + floor(($startMonth + $monthOffset - 1) / 12); // Добавляем год, если месяц > 12

        // Количество дней в текущем месяце
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
        $schedule = []; // Массив для расписания

        // Создаем расписание
        while ($currentWorkDay <= $daysInMonth) {
            // Проверяем, попадает ли рабочий день на ыходной 
            $dayOfWeek = date('N', strtotime("$currentYear-$currentMonth-$currentWorkDay"));

            if ($dayOfWeek == 6) { 
                $currentWorkDay += 2; 
            } elseif ($dayOfWeek == 7) { 
                $currentWorkDay += 1; 
            }

            // Проверяем, все ли еще в пределах месяца
            if ($currentWorkDay <= $daysInMonth) {
                $schedule[$currentWorkDay] = "Рабочий день"; // Записываем рабочий день
            }

            $currentWorkDay += 3; 
        }

        // Выводим расписание
        echo $months[$currentMonth] . " " . $currentYear . ":\n";
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (isset($schedule[$day])) {
                echo "\033[32m$day: " . $schedule[$day] . "\n\033[0m";
                } else {
                // Проверяем, день выходной или нет
                $dayOfWeek = date('N', strtotime("$currentYear-$currentMonth-$day"));
                if ($dayOfWeek == 6 || $dayOfWeek == 7) {
                    echo "$day: Выходной\n"; 

                } else {
                    echo "\033[31m$day: Не рабочий\n\033[0m"; // Дни, которые не рабочие и не выходные
                    }
            }
        }
        echo "\n"; 
        $currentWorkDay = 0; // Сброс текущего рабочего дня для следующего месяца
    }
}

generateWorkSchedule(2024, 10, 3); 