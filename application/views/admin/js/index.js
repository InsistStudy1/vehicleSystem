/**
 * Created by Administrator on 18-5-17.
 */
$(document).ready(function() {
    $('#sidebar .hasSub').on('click', function () {
        $thisNav = $(this).find('.sub');
        $thisArrow = $(this).children('a').children('i').eq(1);
        if($thisNav.css('display') == 'none'){
            $thisArrow.css('transform','rotate(-180deg)');
            $thisNav.slideDown(.7);
        }else {
            $thisArrow.css('transform','rotate(0deg)');
            $thisNav.slideUp(.7);
        }
    })
}())
