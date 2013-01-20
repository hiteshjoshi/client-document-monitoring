jQuery(function() {
			jQuery('#file_upload').uploadifive({
				'auto'         : true,
				'formData'     : {'action' : 'handle_upload'},
				'queueID'      : 'queue',
				'uploadScript' : ajaxurl,
                                'removeCompleted' : true,
                                'fileSizeLimit':'',
                                'onFallback':function(){
                                            noty({"text":"The browser does not support HTML5, Please user some modern browser. Like Google Chorome, Mozilla firefox, or IE9+","layout":"top","type":"error","animateOpen":{"height":"toggle"},"animateClose":{"height":"toggle"},"speed":500,"timeout":5000,"closeButton":true,"closeOnSelfClick":true,"closeOnSelfOver":false,"modal":true});
                                },
				'onUploadComplete' : function(file, data) {
					data = jQuery.parseJSON(data);
                                        if(data.error){

                                            notyy('error',data.msg);



                                        }else{

                                          notyy('success',data.msg);
                                      }


                                        if(data.file_data) show_input(data.file_data);




				}
			});

jQuery("button.add_single").live('click',function(){assign(jQuery(this).attr('id'));});

jQuery("button#assign_all").live('click',function(){jQuery("#files_input table tbody tr").each(function(){assign(jQuery(this).attr('id'));});});



		});

function show_input(data){

    var users='';
    jQuery.post(ajaxurl,{action:'get_usernames'},function(d){
        if(jQuery.each(d,function(i,v){
            users += '<option value="'+v.id+'">'+v.username+'</option>';

        })){

jQuery("#files_input table tbody").append('<tr id="'+data.id+'"><th>'+data.name+'</th><th><select id="cdm_'+data.id+'" class="multiselect" multiple>'+users+'</select></th><th><button class="add_single" id="'+data.id+'" class="button-primary" >Assign</button></th></tr>').find("select#cdm_"+data.id).multiSelect();
jQuery("#files_input").css({'display':'block'});
        }

    },'json');

}

function assign(file_id){
    var data ={};
    data.file_id = file_id;//;
    data.user_id =jQuery("select#cdm_"+data.file_id).val();
var filename = "table tbody tr#"+data.file_id+" th:first-child";
filename = " for the file "+jQuery(filename).html();

    data.action = 'assign_file';


    jQuery.post(ajaxurl,data,function(d){
        if(d.error){
            jQuery.noty.clearQueue();
            notyy('error',d.msg+filename);
        }
        else{
            jQuery.noty.clearQueue();
            notyy('information',d.msg+filename);
            jQuery("tr#"+file_id).fadeOut(500).remove();

        }
    },'json');}
