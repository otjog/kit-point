<h1>Version 0.4.7 at 15.11.2019</h1>

<hr>
<h2>Version 0.4.7 at 15.11.2019</h2>
<hr>
<h3>Добавлен функционал выгрузки прайслистов в формате YML для Марктеплейсов</h3>

<ol>
    <li>
        Добавлены 2 таблицы:
        <ul>
            <li>
                shop_marketplaces
            </li>
            <li>
                shop_marketplace_has_product - для каждого маркетплейса можно выбрать свои товары
            </li>
        </ul>
    </li>
    <li>
        Для поиска яндекса также можно выгрузить прайслист YML всех товаров
    </li>
</ol> 
<strong>
    TODO: после миграции в таблице shop_marketplaces добавить маркетплейсы. И в таблице shop_marketplace_has_product
    добавить товары к каждому маркетплейсу.
</strong>

<hr>
<h2>Version 0.4.6 at 03.11.2019</h2>
<hr>
<h3>Ajax добавление товара в корзину</h3>

<ol>
    <li>
        Изменение внешнего вида кнопки при добавлении товара в корзину
    </li>
    <li>
        Изменение цены с учетом скидок от количества
    </li>
</ol> 
<strong>
    TODO: после миграции в таблице discounts проставить price_id
</strong>
<hr>
<h3>Добавлен функционал скидок от количества товара</h3>

<ol>
    <li>
        Исправлены 2 таблицы:
        <ul>
            <li>
                discounts - добавлено поле price_id, устанавливающий для какого типа цен действует данная скидка.
            </li>
            <li>
                product_has_discount - добавлено поле quantity, устанавливаюшее количество товара, с которого начинает действовать данная скидка
            </li>
        </ul>
    </li>
    <li>
        Для скидки по умолчанию qunatity = 1
    </li>
    <li>
        Скидки от количества плюсуются к скидке по умолчанию
    </li>
</ol> 
<strong>
    TODO: после миграции в таблице discounts проставить price_id
</strong>

<hr>
<h2>Version 0.4.5.1 hotfix at 03.09.2019</h2>
<hr>
<h2>Version 0.4.5 at 02.09.2019</h2>
<hr>
<h3>
    Добавлен простейший функционал отписки от рассылки
</h3>
<ol>
    <li>
        На сервере сохраняется файл public/storage/subscribes/*.txt, где имя файла = адрес эл.почты
    </li>
</ol>

<hr>

<h3>
    Добавлен функционал Breadcrumbs
</h3>

<ol>
    <li>
        Создан класс Breadcrumbs, который принимает текушую модель
    </li>
    <li>
        В качестве названия "крошки" берется параметр "name" переданной модели. Если параметра нет по умолчанию в модели определен метод getNameAttribute, который при каждом обращении к параметру name текущей модели, будет отдавать рещультат этой функции.
    </li>
    <li>
        Класс расчитан на категории ИМ и прямые ссылки на статьи и прочее. При добавлении новых компонентов, например Блога, нужно переписывать роуты и собственно функционал breadcrumbs
    </li>
    <li>
        В модели Category созданы отношения на саму себя childrens и parent. parent используется в breadcrumbs.
    </li>
    <li>
        В модели Product получение category через leftJoin заменено на with(...), чтобы в классе breadcrumbs иметь оперативный доступ к parent.
    </li>
</ol>

<hr>

<h3>
    Изменен код для переменной GlobalData
</h3>

<ol>
    <li>
        Создан фасад GlobalData, который, через GlobalDataServiceProvider через singletone связан с классом GlobalData.
    </li>
    <li>
        Модель Settings удалена.
    </li>
    <li>
        Все параметры теперь грузятся в конуструкторе класса GlobalData
    </li>
</ol>

<hr>

<h3>
    Изменена временная зона на Europe/Moscow
</h3>
================================================================
Добавлен функционал Расссылка писем покупателям

 1. Добавлена таблица mailling
 2. Слушатель рассылок проверяет рассылки 1 раз в час.
 Минуты, указанные в параметрах рассылки не учитываются.
 3. Рассылка производится:
  - либо по адресам из текстового файла, поле file_src
  - либо пользователям определенной группы, поле customer_group_id
 4. Файл с адресами должен быть след.формата
  ivanov@ivan.ru Иванов Иван
  petrov@petr.ru Петров Петр
 5. Если указан путь к файлу, то группа пользователей не учитывается.
 Чтобы сделать рассылку по группам пользователей, нужно поле
 file_src оставить в null, а в поле customer_group_id указать
 id необходимой группы.
 6. Чтобы добавить в рассылку товары, нужно в json-строке поля options
 добавить значение shop_offer: alias_offer. Где shop_offer это ключ,
 alias_offer это alias необходимого товарного предложения.
 7. Остальные значения для поля options
  - mail_subject - тема письма. Можно подставить имя получателя
  подставив {{full_name}}
  - mail_template - путь у шаблону письма, относительно папки views
  - html_values - переменные, которые можно подставлять в шаблон

================================================================
Добавлен функционал Группы покупателей

 1. Добавлена таблица shop_customer_groups. После миграции
необходимы дополнительные действия.

TODO
 1. После миграции нужно одну из групп покупателей назначить
 по-умолчанию, поставив 1 в поле default. Эта группа для 
 покупателей, которые не авторизованы на сайте. При формировнаии
 цен price_id будет браться из группы.
 2.  После миграции группы пользователей имеют alias и name,
 такие же как и у соответствующей таблицы price. 
 Можно переименовать на более соответствующие. Поля alias не
 обязаны соотвествовать у этих таблиц.

================================================================
Улучшена мобильная версия шаблона _kp

================================================================
Version 0.4.4 at 22.08.2019 
================================================================
Добавлено описание для страницы Категории Товаров

 1.В таблицу categories, добавлена строка description, в которой
 хранится  описание для каждой категории.
 2.В шаблоне _kp для категории выводится описание, если оно есть в БД

================================================================
Добавлен Слайдер для миниатюр в карточке товара

 1.Добавлен вертикальный слайдер для миниатюр изображений
 в карточке товара.
 2.Исправлены недочеты в работе Табов в карточке товара
================================================================
Добавлен функционал "Водяной знак"

 1. В global_data, в разделе images, для каждой модели и для 
 каждого размера для параметра changes можно добавить значение watermark.
 2. В качестве изображения для водяного знака используется
 логотип, путь к которому указан в global_data->info->logotype.
===============================================================

================================================================
Version 0.4.3 at 20.08.2019 
================================================================
Подравлен шаблон по умолчанию _kp

 1. Карточка товара - название товара перенесено выше картинок
 2. Не отображаются вкладки, если в них нет данных
 3. Для Product->description текст не экранируется и выводится с помощью {!! $ !!}
 4. На странице категории данные в фильтре теперь выводятся в алфавитном порядке

================================================================
Добавлена функционал "Регистрация клиентов"

 1. Исправлена таблица customers
    - таблица переименована в shop_customers
    - в таблицу добавлены поля 'password', 'password_token', 'price_id'
    - полю 'email' добавлен атрибут unique и увеличена длина строки
 2. Любой не зарегистрированный клиент автоматически регистрируется на сайте
 после оформления заказа. Для него формируется случайный пароль, который НЕ высылается на почту.
 Чтобы клиенту войти в учетную запись необходимо восстановить пароль через форму восстановления на странице входа.
 Уведомление о регистрации клиента после оформления заказа НЕ приходит на почту компании.
 3. Клиент может пройти регистрацию на сайте. После регистрации и клиенту и компании
 приходит уведомление на почту. 
 4. Каждому клиенту можно назначить тип цен. По умолчанию пользователю назначается тип цен, который определен по умолчанию.
 5. Аутентифицированный клиент при оформлении заказа заполняет только адрес доставки, а также выбирает способ доставки и оплаты.
 6. Если клиент зарегестрирован, но не аутентифицирован на сайте и, если он оформляет заказ указав почту, прявязанную к его аккаунту, то заказ оформится на этого пользователя, но по ценам, определенным по умолчанию.
 Для оформления заказов по своим ценам пользователю обязательно нужно пройти аутентификацию.
 7. Новые шаблоны писем для:
 	- Оформление заказа
	- Новый клиент
	- Сброс пароля
	
===================================================================
Добавлен функционал "Остатки товаров на складах"

 1. Добавлены 2 таблицы:
    shop_stores - для складов
    shop_store_has_product - для записи остатков каждого продукта на каждом складе
 2. В карточке товара шаблона kp отображается надпись "В наличии", если товар есть хотя бы
 на одном из складов, и надпись "Нет в наличии", если товара нет ни на одном из складов.
 3. В карточке товара шаблона _kp недоступна форма добавления товара в корзину если товара нет ни наодном из складов.   
 4. На странице категории шаблона kp недоступна форма добавления товара в корзину если товара нет ни наодном из складов, вместо кнопки добавления появляется надпись "Нет в наличии".
 
===================================================================

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