- изменен layout, добавлен блок апи-котировок в хедер
- изменены стили моб/десктоп, локализация

-- v.0.3_subscribe
- добавлены модель и миграция Subscriber, livewire компонент подписки
- роут изменения подписки в профиле, изменено отображение в профиле
- добавлена связь пользователя с подпиской и обратно
- добавлно создание подписки регистрирующимся пользовтелям и удаление при удалении пользователя
- при подписке на "не свою почту" - уведомление, для перехода в профиль

-- v.0.3_sitemap_up
- добавлен человечий сайтмап
- добавлена компонент кнопка наверх страницы
- добавлено поле user_token, таблице post_views
- добавлены уникальные двухчасовые куки для страниц постов, чтобы не было дублей в с татистике просмотров постов
- изменен админский дашборд, добавлены админские виджеты


-- v.0.2_share
- добавлены разметка для страниц постов, кнопки поделиться в соцсетях для постов
- добавлен роботс.тхт, добавлены фавикон
- добавлен ->onDelete('cascade') в post_views_table
- размечена шапка: рел=некст,прев,каноникал; title,descript=" - Страница #"
- пагинация: убран дубль ?page=1
- добавлена карта сайта xml
- обновлены категории в шапке и сайдбаре, выводятся только с активными постами
- обновлен блок рекомендованные статьи(для авторизовавшихся пользователей), убраны дубли.

-- v.0.1.post-related-n-fields
- добавлены поля meta_title_en, meta_description_en, title_en, body_en в таблицу posts и $fillable модели Post.
- вывод полей в админ панели (en/ru) просмотр/редактирование в виде вкладок {Post}
- созданы базовые словари локализации app/lang и добавлен список возможных локалей в config/app.php
- создан миддлвар смены языка и добавлен в кернел, созданы роуты и переключатель в шапке
- добавлен класс Constants для глобальных данных
- добавлен вывод _en переменных Post в шаблоны, в зависимости от локали
- добавлено удаление дочерних комментов, при удалении родительского
- поправлено отображение подсветки лайк/дислайк
- добавлены поля в таблицу 'meta_title_en', 'meta_description_en', 'meta_title', 'meta_description', 'title_en' и в $fillable для Category
- добавлен вывод _en полей для Category
- количество дочерних веток комментариев сокращено до одной
- добавлены отношения между постами. пост может быть связан с другим постом(серия постов на одну подтему)
- добавлен вывод связанных постов, после перелинковки соседних статей
