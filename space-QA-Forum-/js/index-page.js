/**
 * Created by Sagar on 03-Apr-15.
 */
$(document).ready (function() {
    $(".answer-slider").dblclick( function () {
        $(this).hide(500);
        $t = $(this);
        $(this).next().slideToggle(500,function clearSelection() {
            if(document.selection && document.selection.empty) {
                document.selection.empty();
            } else if(window.getSelection) {
                var sel = window.getSelection();
                sel.removeAllRanges();
            }
            $t.prev().ScrollTo({duration:1000});
        });
    });
});
$(document).ready (function() {
    $(".answer").dblclick( function () {
        $(this).slideToggle(500,function(){
            $(this).prev().show(600,function clearSelection() {
                if(document.selection && document.selection.empty) {
                    document.selection.empty();
                } else if(window.getSelection) {
                    var sel = window.getSelection();
                    sel.removeAllRanges();
                }
            });
        });
    });
});
$(document).ready (function() {
    $(".my-abuttonsapt").click(function (){
        var aid = $(this).prev().attr('value');
        var $t = $(this);
        $.post('scripts/incrapt.php',{aid: aid}, function (data,status) {
            if (data!='err')
                $t.children('.badge').html(data);
        });
    });
});

$(document).ready (function() {
    $(".my-abuttonsnotapt").click(function (){
        var $t = $(this);
        var aid = $(this).prev().prev().attr('value');
        $.post('scripts/incrnotapt.php',{aid: aid}, function (data,status) {
            if (data!='err')
                $t.children('.badge').html(data);
        });
    });
});

$(document).ready (function() {
    $(".my-qbuttons").click(function (){
        var qid = $(this).prev().attr('value');
        var $t = $(this);
        $.post('scripts/incrcurious.php',{qid: qid},function(data,status){
            if (data!='err')
                $t.children('.badge').html(data);
        });
    });
});

function checkQuestion()
{
    var Q = document.getElementById('new-question');
    if (Q.value.indexOf("?")!=Q.value.length-1)
    {
        Q.value+='?';
    }
}

$(document).ready (function() {
    $('a.displayAnswerQuestionBlock').click(function(){
        $(this).next().show(1000);
        $(this).ScrollTo({duration:1000});
    });
});

$(document).ready (function() {
    $('a.hideAnswerQuestionBlock').click(function(){
        var $tmp = $(this).parent().parent().prev().prev().prev();
        $(this).parent().hide(1000);
        $tmp.ScrollTo({duration:1000});
    });
});
