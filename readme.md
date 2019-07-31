<h1>Версия 0.4.2 at 30.07.2019</h1>

<p>После клонирования необходимо произвести следующие действия:</p>
<ul>
    <li>
        Выполнить: <strong>composer install</strong>
    </li>
    <li>
        Создать файл <strong>.env</strong> и заполнить его
    </li>
    <li>
        Выполнить: <strong>php artisan key:generate</strong>
    </li>
    <li>
        Выполнить: <strong>php artisan storage:link</strong>
    </li>
    <li>
        Выполнить: <strong>php artisan migrate</strong>
    </li>  
    <li>
        Выполнить: <strong>php artisan db:seed</strong>
    </li>     
    <li>
        Создать следующие файлы:
        <ul>
            <li>
                <strong>public/favicon.ico</strong>
            </li>
            <li>
                <strong>public/.htaccess</strong>
            </li>                       
        </ul>        
    </li>
    <li>
        Из файла <strong>.gitignore</strong> удалить все вышеперечисленные пути
    </li>
    <li>Вставить <strong>GeoLite2-City.mmdb</strong> и <strong>GeoLite2-Country.mmdb</strong> в папку <strong>storage/app/public/geolite/</strong>
    </li>
</ul>
