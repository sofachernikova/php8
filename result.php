<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Черникова Софья Кирилловна, 201-321</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>



    <header class="header">

        <div class="header__logo__block">
            <img class="header__logo" src="logo.png" alt="Логотип МПУ">
        </div>

        <div class="header__info__block">
            <p class="header__info__p">Черникова Софья Кирилловна, 201-321</p>
            <a href="https://github.com/sofachernikova/php8.git" class="header__info__p">Ссылка на гитхаб</a>
        </div>

    </header>



    <main class="main">

        <?php

        if (isset($_POST['text']) && $_POST['text']) {
            echo '<div class="div"><h3 class="h3">Исходный текст</h3>';
            echo '<p class="main-text">' . $_POST['text'] . '</p>';
            test_it($_POST['text']);
        } else {
            echo '<div class="div"><h3 class="h3">Вы не ввели текст</h3>';
        }

        echo '</div>';

        //  ФУНКЦИЯ АНАЛИЗА

        function test_symbs($text)
        {
            $symbs = array();
            $l_text = mb_convert_case($text, MB_CASE_LOWER, "UTF-8");
            $l_text_array = mb_str_split($l_text);
            for ($i = 0; $i < iconv_strlen($l_text); $i++) {
                if (isset($symbs[$l_text_array[$i]]))
                    $symbs[$l_text_array[$i]]++;
                else
                    $symbs[$l_text_array[$i]] = 1;
            }
            return $symbs;
        }
        function test_it($text)
        {

            //      МАССИВЫ С ДАННЫМИ
            $cifra = array(
                '0' => true, '1' => true, '2' => true, '3' => true, '4' => true,
                '5' => true, '6' => true, '7' => true, '8' => true, '9' => true
            );

            $znak = (array(
                '.' => true, ',' => true, ';' => true, ':' => true,
                '?' => true, '!' => true, '-' => true, '(' => true, ')' => true, '"' => true
            ));


            //      ПЕРЕМЕННЫЕ

            $cifra_amount = 0;
            $znak_amount = 0;
            $lower_amount = 0;
            $upper_amount = 0;
            $word = '';
            $word_amount = 0;
            $words = array();
            $simvol = array();
            $bukva_amount = 0;
            $text .= ' ';
            $len = iconv_strlen($text) - 1;
            $text_copy = mb_strtolower($text);
            for ($i = 0; $i < strlen($text); $i++) {


                //            счетчик букв
                $bukva_amount = iconv_strlen(preg_replace('/[^A-Za-zа-яёА-ЯЁ]/u', '', $text));
                //            счетчик ЗАГЛАВНЫХ букв
                $upper_amount = iconv_strlen(preg_replace('/[^A-ZА-ЯЁ]/u', '', $text));
                //            счетчик СТРОЧНЫХ букв
                $lower_amount = iconv_strlen(preg_replace('/[^a-zа-яё]/u', '', $text));

                //            счетчик цифр
                if (array_key_exists($text[$i], $cifra))
                    $cifra_amount++;
                //            счетчик знаков препинания
                if (array_key_exists($text[$i], $znak))
                    $znak_amount++;
                //            счетчик разных слов
                if ($text[$i] == ' ' || $i == strlen($text) - 1 || array_key_exists($text[$i], $znak) || array_key_exists($text[$i], $cifra)) {
                    if ($word) {
                        if (isset($words[$word])) {
                            $words[$word]++;
                            $word_amount++;
                        } else {
                            $word_amount++;
                            $words[$word] = 1;
                        }
                    }
                    $word = '';
                } else
                    $word .= $text[$i];
            }

            echo '<h3 class="h3">Анализ текста</h3>
                <table>
                    <tr>
                        <td class="td">Количество символов в тексте (включая пробелы)</td>
                        <td class="td-data">' . $len . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество букв</td>
                        <td class="td-data">' . $bukva_amount . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество строчных и заглавных букв по отдельности</td>
                        <td class="td-data">Заглавных букв: ' . $upper_amount . '<br>Строчных букв: ' . $lower_amount . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество знаков препинания</td>
                        <td class="td-data">' . $znak_amount . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество цифр</td>
                        <td class="td-data">' . $cifra_amount . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество слов</td>
                        <td class="td-data">' . $word_amount . '</td>
                    </tr>
                    <tr>
                        <td class="td">Количество вхождений каждого символа текста (без различия верхнего и нижнего регистров)</td>
                        <td class="td-data">';
            //      СПИСОК СИМВОЛОВ
            $simvol = test_symbs($text_copy);
            $keys_simvol = array_keys($simvol);
            $l = 1;

            foreach ($keys_simvol as $item) {
                if ($item == " ") {
                    $simvol[$item]--;
                }
                if ($simvol[$item] == 0) {
                    continue;
                } else {
                    if ($l != count($keys_simvol)) {
                        echo '"' . $item . '" : ' . $simvol[$item] . '<br>';
                        $l++;
                    } else {
                        echo '"' . $item . '" : ' . $simvol[$item];
                    }
                }
            }
            echo '
                        </td>
                    </tr>';
            echo '<tr>
                        <td class="td">Список всех слов в тексте и количество их вхождений, отсортированный по алфавиту</td>
                        <td class="td-data">';
            //      СПИСОК СЛОВ
            $keys = array_keys($words);
            sort($keys);
            $l = 0;

            foreach ($keys as $item) {
                if ($l != count($keys) - 1) {
                    echo $item . ' : ' . $words[$item] . '<br>';
                    $l++;
                } else {
                    echo $item . ' : ' . $words[$item];
                }
            }
            echo '
                        </td>
                    </tr>';

            echo '</table>';
        }

        ?>

    </main>



    <footer class="footer">

        <p class="footer__p">Лабораторная работа №8</p>

    </footer>



</body>

</html>