<?php

return
        array(
            '/^category_(\d+)$/' => 'Content/Content/category?cid=:1',
            '/^artlist_(\d+)$/' => 'Content/Content/newslist?cid=:1',
            '/^artlist_(\d+)_(\d+)$/' => 'Content/Content/newslist?cid=:1&p=:2',
            '/^news_(\d+)_(\d+)$/' => 'Content/Content/news?cid=:1&id=:2',
            '/^page_(\d+)$/' => 'Content/Content/page?cid=:1',
            '/^guestbook$/' => 'Component/Guestbook/index',
);

