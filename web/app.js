/**
 * Created by IvanMatas on 7/20/2016.
 */
$(document).ready(function() {
init_multifield(5, '.input_fields_wrap', '.add_task');
//init_multifield(5, '.input_fields_wrap2', '.add_field_button2', 'user_music2[]');

    $("#report").jExpand();
    $(".infos").hide();
    $("#addTask").hide();
    $("#editTask").hide();


function init_multifield(max, wrap, butt) {
    var max_fields = max; //maximum input boxes allowed
    var wrapper = $(wrap); //Fields wrapper
    var add_button = $(butt); //Add button class
    //var fname = fname_p;

    var x = 0; //initlal text box count
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            var cstring =$(wrapper).append('<div><h5>Task '+x+'</h5> <button class="delete">Delete</button> <div class="form-group"> <label for="task_name">Task name: </label> <input class="form-control"  id="task_name" name="taskName'+x+'" /> </div> <div class="form-group"> <label>Task priority: </label> <select name="priority'+x+'"> <option  id="priority1" name="priority1" value="high" selected >High</option> <option  id="priority2" name="priority2 "value="normal">Normal</option> <option  id="priority3" name="priority3" value="low">Low</option> </select> </div> <div class="form-group"> <label for="deadline">Deadline: </label> <input class="form-control"  id="deadline" name="deadline" type="date" /> </div><br><br></div>');
            eval(cstring);
        }
    });

    $(wrapper).on("click", ".delete", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    })
    }


    $(".delete-task").click(function (e) { //on add input button click
        e.preventDefault();
        var id= $(this).parent().parent().find(".id").text();
        console.log(id);
        $(this).parent().parent().remove();
        $.ajax({
            url: "/delete",
            type: 'post',
            data: {'id': id},
            //data: id,
            success: function () {
                $(".infos").append("<div class='alert alert-info'><strong>Info!</strong> Task with an id: "+id+" was deleted! <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>.");
                $(".infos").show();
            },

            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });

    $(".edit-task").click(function (e) { //on add input button click
        e.preventDefault();
        //var id= $(this).parent().parent().find(".id").text();
        var name2= $(this).parent().parent().find(".name").text();
        console.log(name2);
        $("#editTask").dialog();

        $(".task_edit").click(function (e) { //on add input button click
            e.preventDefault();
            var name= $(this).parent().find(".task-name").text();
            console.log(name);
            $.ajax({
                url: "/dashboard/edit",
                type: 'post',
                data: {'dialog_task_name': name, 'dialog_task_name2':name2 },
                //data: id,
                success: function () {
                    console.log(id);
                },

                error: function(xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
        });
    });



    $(".delete-list").click(function (e) { //on add input button click
        e.preventDefault();
        var id_list= $(this).parent().parent().find(".id_list").text();
        console.log(id_list);
        $(this).parent().parent().next("tr").remove();
        $(this).parent().parent().remove();
        $.ajax({
            url: "/delete",
            type: 'post',
            data: {'id_list': id_list},
            //data: id,
            success: function() {
                $(".infos").append("<div class='alert alert-info'><strong>Info!</strong> List with an id: "+id_list+" and all tasks inside were deleted! <a href='' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>.");
                $(".infos").show();

            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });

    $(".add-task").click(function (e) { //on add input button click
        e.preventDefault();
        $("#addTask").dialog();
        /*var id= $(this).parent().parent().find(".id").text();
        console.log(id);
        $(this).parent().parent().remove();
        $.ajax({
            url: "/edit",
            type: 'post',
            data: {'id': id},
            //data: id,
            success: function(data, status) {
                if(data == "ok") {
                 $('#report').html('<p><em>Following!</em></p>');
                    console.log(id);
                }
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });*/
    });

    $("#task_add").click(function (e) { //on add input button click
        e.preventDefault();

        var name= $("#task_namez").text();
        //var name= $(this).parent().find("#task_name").text();
        console.log(name);
        $.ajax({
            url: "/dashboard/add",
            type: 'post',
            data: {'dialog_name': name},
            //data: id,
            success: function(data, status) {
                if(data == "ok") {
                 $('#report').html('<p><em>Following!</em></p>');
                    console.log(id);
                }
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    });


   /* $(".delete-task").on("click", function(e){
        e.preventDefault();
        $(tasks).fadeOut(300);
        $(this).parent('div').remove();*/

        /*$.ajax({
            url: 'php/ajax-follow.php',
            type: 'post',
            data: {'action': 'follow', 'userid': '11239528343'},
            success: function(data, status) {
                if(data == "ok") {
                    $('#followbtncontainer').html('<p><em>Following!</em></p>');
                    var numfollowers = parseInt($('#followercnt').html()) + 1;
                    $('#followercnt').html(numfollowers);
                }
            },
            error: function(xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        }); // end ajax call*/
    //})

    $('th').click(function(){
        var table = $(this).parents('table').eq(0)
        var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
        this.asc = !this.asc
        if (!this.asc){rows = rows.reverse()}
        for (var i = 0; i < rows.length; i++){table.append(rows[i])}
    })
    function comparer(index) {
        return function(a, b) {
            var valA = getCellValue(a, index), valB = getCellValue(b, index)
            return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB)
        }
    }
    function getCellValue(row, index){ return $(row).children('td').eq(index).html() }
});




