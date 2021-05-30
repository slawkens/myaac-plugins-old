<?php
defined('MYAAC') or die('Direct access not allowed!');
?>
<!doctype html>
<html lang="en">
<head>
    <?php echo template_place_holder('head_start'); ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        $(function() {
            $('select').addClass('select-form');
        });
    </script>
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
    <!-- Icons -->
    <link rel="shortcut icon" href="<?php echo $template_path; ?>/images/favicon.gif" />
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo $template_path; ?>/style.css">
    <?php echo template_place_holder('head_end'); ?>
</head>
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" aria-label="Navigation bar">
    <div class="container">
        <a class="navbar-brand" href="?home">
            <img src="<?php echo $template_path; ?>/images/<?php echo config('header-logo'); ?>" alt="" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbars" aria-controls="navbars" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbars">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" aria-current="page" href="?home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?news">News</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false">Wiki</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown07">
                        <li><a class="dropdown-item" href="<?php echo $template['link_creatures']; ?>">Monsters</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_spells']; ?>">Spells</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_experienceStages']; ?>">Experience stages</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_commands']; ?>">Commands</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_serverInfo']; ?>">Server Information</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false">Community<b class="caret"></b></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown07">
                        <li><a class="dropdown-item" href="<?php echo $template['link_characters']; ?>">Characters</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_online']; ?>">Online</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_highscores']; ?>">Highscores</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_lastkills']; ?>">Last kills</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_houses']; ?>">Houses</a></li>
                        <li><a class="dropdown-item" href="<?php echo $template['link_guilds']; ?>">Guilds</a></li>
                        <?php if (isset($config['wars'])) : ?>
                            <li><a class="dropdown-item" href="<?php echo $template['link_wars']; ?>">Guild Wars</a></li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="?forum">Forum</a>
                </li>
                <?php if ($config['gifts_system'] && $logged) : ?>
                    <?php if ($logged) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false">Shop<b class="caret"></b></a>
                            <ul class="dropdown-menu" aria-labelledby="dropdown07">
                                <li><a class="dropdown-item" href="<?php echo $template['link_points']; ?>">Buy points</a></li>
                                <li><a class="dropdown-item" href="<?php echo $template['link_gifts']; ?>">Gifts</a></li>

                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

            <?php if (!$logged) { ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?account/manage">Login</a>
                    </li>
                    <li class="nav-item" style="margin-right:10px;">
                        <a class="nav-link" href="?account/create">Register</a>
                    </li>
                </ul>
            <?PHP } else { ?>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown07" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $account_logged->getName(); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown07">
                            <li><a class="dropdown-item" href="<?php echo $template['link_account_manage']; ?>">Account</a></li>
                            <?php if(admin()){ ?>
                                <li><a class="dropdown-item" href="<?php echo ADMIN_URL; ?>"  target="_blank">Admin Panel</a></li> 
                            <?PHP } ?>
                            <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>?subtopic=accountmanagement&action=logout">Sign out</a></li>
                        </ul>
                    </li>
                </ul>
            <?PHP } ?>
            <ul>
                <li style="margin-bottom:-15px;margin-left:-32px;">
                    <?php if ($status['online'])
                        echo '
                        <button type="button" class="btn btn-success" data-html="true" data-toggle="tooltip" title="
                            IP: rebornot.net
                            Port: 7171
                            Client: ' . ($config['client'] / 100) . ' 
                            Type: PvP   
                            Players Online: ' . $status['players'] . ' / ' . $status['playersMax'] . '
                            Uptime: ' . (isset($status['uptimeReadable']) ? $status['uptimeReadable'] : 'Unknown') . ' ">
                            Server Online
                        </button>';
                    else
                        echo '
                            <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Server Offline">
                            Server Offline
                            </button>';
                    ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<body class="py-5" id="bootstrap-overrides">
    <?php echo template_place_holder('body_start'); ?>
    <div class="container table-responsive">
        <div class="card border-0 shadow-md my-2 my-md-5" id="bootstrap-overrides">
            <div class="card-body-md py-3 px-md-5" id="bootstrap-overrides">
                <?php
                if (empty($uri) || isset($_REQUEST['template'])) {
                    $_REQUEST['p'] = 'home';
                    $found = true;
                }
                echo template_place_holder('center_top') . $content;
                ?>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center pt-5">
        <div class="align-items-center">
            <p class="text-center bottom-text">
                <?php echo template_footer(); ?>
                Template by: <a href=https://otland.net/members/jonasu.65771/" target="_blank">Xitobuh</a>
                <?php if ($config['template_allow_change']) : ?>                
                       <?php echo template_form(); ?>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <script>//Design functions
        $(function() {
            $('select').addClass('form-select');
            $('input[type=text]').addClass('form-control');
            $('input[type=search]').addClass('form-control');
            $('input[type=submit]').addClass('btn btn-secondary');
            $(".dataTables_length" ).addClass( "form-group");
            $(".dataTables_filter" ).addClass( "form-group");
            $("table" ).attr("class", "table")
            $("thead").addClass( "table-dark");
            $("th").attr("scope", "col");
        });
    </script>               
    <?php echo template_place_holder('body_end'); ?>
</body>

</html>