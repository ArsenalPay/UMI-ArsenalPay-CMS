# UMI-ArsenalPay-CMS
UMI ArsenalPay CMS is software development kit for fast simple and seamless integration of your UMI web site with processing server of ArsenalPay.

*Arsenal Media LLC*  
[*Arsenal Pay processing server*]( https://arsenalpay.ru/)

*Has been tested on UMI.CMS version 15*

#### Basic feature list:  
 * Allows seamlessly integrate payment widget into your site.
 * New payment method ArsenalPay will appear to pay for your products and services.
 * Allows to pay using bank cards VISA/MASTERCARD/MAESTRO, mobile balance (MTS/Megafon/Beeline/TELE2) and e-wallet. More methods are about to become available. Please check for updates.

#### О МОДУЛЕ
* Модуль платежной системы ArsenalPay для UMI.CMS позволяет легко встроить платежный виджет на Ваш сайт.
* После установки модуля у Вас появится новый вариант оплаты товаров и услуг через платежную систему ArsenalPay.
* Платежная система ArsenalPay позволяет совершать оплату с различных источников списания средств: пластиковых карт (VISA/MasterCard/Maestro), мобильных номеров (МТС/Мегафон/Билайн/TELE2), различных электронных кошельков. Перечень доступных источников средств постоянно пополняется. Следите за обновлениями.

За более подробной информацией о платежной системе ArsenalPay обращайтесь по адресу https://www.arsenalpay.ru

#### УСТАНОВКА
1. Скопировать файлы в корень Вашего сайта, сохраняя структуру вложенности папок.
2. В строке браузера прописать ```{имя_вашего_домена}/arsenalpay_init.php``` (этап установки модуля в базу данных)
3. Удалить файл ```arsenalpay_init.php``` с корня Вашего сайта.
4. Перейти в административную панель сайта в модуль **Интернет-магазин**.
5. На вкладке **Оплата** добавить способ оплаты **ArsenalPay**.
6. Заполнить данные:
  - Название - название метода оплаты, которое будет предложено пользователю при покупке в магазине (рекомендовано "ArsenalPay")
  - Callback Key - Ключ для проверки подписи запросов, обязательный;
  - Widget Key -  Ключ для проверки виджета, обязательный;
  - Widget ID - Уникальный идентификатор виджета, обязательный;
7. Сообщить нам Ваш колбэк-урл для уведомлений: ```{имя_вашего_домена}/emarket/gateway/```

Если шаблоны Вашего сайта находятся в папке templates, и Ваша тема отличается от дефолтной demodizzy, то необходимо также проделать следующее:
1. В случае tpls шаблонизаторов скопировать файлы из папки ```templates/demodizzy/tpls``` в соответствующую папку вашей темы ```templates/папка_с_вашей_темой/tpls```.
2. В случае php шаблонизаторов скопировать файлы из папки ```templates/demodizzy/php``` в соответствующую папку вашей темы ```templates/папка_с_вашей_темой/php```.
3. В случае с xslt-шаблонизатором нужно встроить в файл ```templates/папка_с_вашей_темой/xslt/modules/emarket/purchase/payment.xsl```
строчки 421-441 из ```templates/demodizzy/xslt/modules/emarket/purchase/payment.xsl```
 
#### ИСПОЛЬЗОВАНИЕ
После успешной установки и настройки модуля на сайте появится возможность выбора платежной системы ArsenalPay.
Для оплаты заказа с помощью платежной системы ArsenalPay нужно:

1. Выбрать из каталога товар, который нужно купить.
2. Перейти на страницу оформления заказа (покупки).
3. В разделе "Платежные системы" выбрать платежную систему ArsenalPay.
4. Перейти на страницу подтверждения введенных данных и ввода источника списания средств (мобильный номер, пластиковая карта и т.д.).
5. После ввода данных об источнике платежа, в зависимости от его типа, либо придет СМС о подтверждении платежа, либо покупатель будет перенаправлен на страницу с результатом платежа.

------------------

### ОПИСАНИЕ РЕШЕНИЯ
ArsenalPay – удобный и надежный платежный сервис для бизнеса любого размера. 

Используя платежный модуль от ArsenalPay, Вы сможете принимать онлайн-платежи от клиентов по всему миру с помощью: 
пластиковых карт международных платёжных систем Visa и MasterCard, эмитированных в любом банке
баланса мобильного телефона операторов МТС, Мегафон, Билайн и ТЕЛЕ2
различных электронных кошельков 

#### Преимущества сервиса: 
 - [Самые низкие тарифы](https://arsenalpay.ru/tariffs.html)
 - Бесплатное подключение и обслуживание
 - Легкая интеграция
 - [Агентская схема: ежемесячные выплаты разработчикам](https://arsenalpay.ru/partnership.html)
 - Вывод средств на расчетный счет без комиссии
 - Сервис смс оповещений
 - Персональный личный кабинет
 - Круглосуточная сервисная поддержка клиентов 

А ещё мы можем взять на техническую поддержку Ваш сайт и создать для Вас мобильные приложения для Android и iOS. 

ArsenalPay – увеличить прибыль просто! 
Мы работаем 7 дней в неделю и 24 часа в сутки. А вместе с нами множество российских и зарубежных компаний. 

#### Как подключиться: 
1. Вы скачали модуль и установили его у себя на сайте;
2. Отправьте нам письмом ссылку на Ваш сайт на pay@arsenalpay.ru либо оставьте заявку на [сайте](https://arsenalpay.ru/#register) через кнопку "Подключиться";
3. Мы Вам вышлем коммерческие условия и технические настройки;
4. После Вашего согласия мы отправим Вам проект договора на рассмотрение;
5. Подписываем договор и приступаем к работе.

Всегда с радостью ждем Ваших писем с предложениями. 

pay@arsenalpay.ru  
[arsenalpay.ru](https://arsenalpay.ru)