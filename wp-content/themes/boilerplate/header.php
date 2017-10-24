<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php if(is_home()) {
        echo "Homepage |"; bloginfo('name');
        } else {
        wp_title('','true','right'); bloginfo('name');
        }
        ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body>