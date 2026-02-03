<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>okazunori's PORTFOLIO</title>
    <?php wp_head(); ?>
</head>

<body>
    <?php wp_body_open(); ?>

    <header class="header">
        <h1 class="logo"><a href="<?php echo home_url(); ?>">okazunori's<br>PORTFOLIO</a></h1>

        <nav>
            <ul class="nav__menu">
                <li class="nav__menu--list"><a href="<?php echo home_url('profile'); ?>">Profile</a></li>
                <li class="nav__menu--list"><a href="<?php echo home_url('web'); ?>">Web</a></li>
                <li class="nav__menu--list"><a href="<?php echo home_url('illust'); ?>">Illust</a></li>
            </ul>
            <div class="nav__hum_icon"></div>
        </nav>
    </header>