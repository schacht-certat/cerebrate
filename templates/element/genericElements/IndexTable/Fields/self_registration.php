<?php
    $self_registration_flag = $this->Hash->extract($row, $field['data_path_requirement']);
    if (empty($self_registration_flag[0])) {
        echo '<i class="black fa fa-times"></i>';
    } else {
        $url = $this->Hash->extract($row, $field['data_path'])[0];
        echo sprintf(
            '<i class="black fa fa-%s"></i>%s',
            (!empty($self_registration_flag[0])) ? 'check' : 'times',
            (empty($self_registration_flag[0])) ? '' :
            sprintf(
                ' (<a href="%s%s/users/register">' . __('click here') . '</a>)',
                $baseurl,
                h($url)
            )
        );
    }
?>
