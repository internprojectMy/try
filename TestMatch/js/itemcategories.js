/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
jQuery(document).ready(function (){
        
        var parentCategorySelectionTree = simTree({
            el: '#trvwCategories',
            data: function (obj,callback) {
                
                //console.log($("#trvwCategories"));
                
                if($("#hdnParentCategorySelected").val()=="")
                {
                    callback(JSON.parse($("#hdnCategories").val()));
                }
                else
                {
                    
                }
   
            },
            check: false,
            linkParent: true,
            //check: true,
            onClick: function (item) {
                
                if(item!=null)
                {
                    if(item.length>0)
                    {
                        if($("#hdnParentCategorySelected").val()==item[0].id)
                        {
                            $("#hdnParentCategorySelected").val("0");
                            var listItems=$("#trvwCategories li");
                            $.each(listItems,function(k,v){
                                if($(v).attr("data-id")==item[0].id)
                                {
                                    $(v).find("a").css("fontWeight","normal");
                                }
                            });
                            
                        }
                        else
                        {
                            $("#hdnParentCategorySelected").val(item[0].id);
                        }
                    }
                }

            },
            onChange: function (item) {
                
            }
        });
        
        var existingCategoriesTree = simTree({
            el: '#trvwExistingCategories',
            data: $.parseJSON($("#hdnCategories").val()),
            check: false,
            linkParent: true,
            //check: true,
            onClick: function (item) {
                
                if(item!=null)
                {
                    if(item.length>0)
                    {
                        var Categories=JSON.parse($("#hdnCategories").val());
                        $.each(Categories,function(k,v){ 
                            if(v.id==item[0].id)
                            {
                                $("#id").val(v.id);
                                $("#code").val(v.CategoryCode);
                                $("#name").val(v.CategoryName);
                                $("#trvwCategories li a").css("fontWeight","normal");
                                $("#hdnParentCategorySelected").val("0");
                                if(v.pid!=null)
                                {
                                    if(v.pid>0)
                                    {
                                        var listItems=$("#trvwCategories li");
                                        $.each(listItems,function(k1,v1){
                                            if($(v1).attr("data-id")==v.pid)
                                            {
                                                $(v1).find("a:eq(0)").css("fontWeight","bold");
                                            }
                                        });
                                        $("#hdnParentCategorySelected").val(v.pid);
                                    }
                                    
                                }
                                
                            }
                        });
                    }
                }
            },
            onChange: function (item) {
                
            }
        });
        
    });

