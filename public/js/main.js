 
/******* NAVIGATION TOGGLE BUTTON *******/
$('#nav-toggle').click(function(){
   $('.main-container__navigation-container').toggleClass('nav-hide');
    /** check if navigation container has no nav-hide class **/
    if(!$('.main-container__navigation-container').hasClass('nav-hide')){
        /** if yes, wait for 300 millisecons then fade in the navigation label **/
        setTimeout(function(){
           $('.main-container__navigation-container__navigation__nav-list > li > a > span').fadeIn(); 
            $('.main-container__navigation-container__welcome__name').fadeIn(); 
        },150)
    }else{ 
        /** if no, hide the navigation label **/
        $('.main-container__navigation-container__navigation__nav-list > li > a > span').hide(); 
        $('.main-container__navigation-container__welcome__name').hide(); 
    }
   $('.open').removeClass('open');
});

/******* EXPAND SUBMENU *******/
$('.main-container__navigation-container__navigation__nav-list > li').each(function(){
    var lielement = $(this);
    lielement.click(function(event){    
        /** check if clicked target is a main menu ***/
        if(!$(event.target).closest('ul').hasClass('main-container__navigation-container__navigation__nav-list')){
             if(event.target.nodeName === "LI"){
                window.location = $(event.target).children('a').attr('href')
            }
        }
    }); 
});


/******* CHECK/UNCHECK CHECKBOX *******/
$('#selecctall').click(function(event) {  //on click 
    if(this.checked) { // check select status
        $('.table--data tr td:first-child input[type="checkbox"]').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"               
        });
    }else{
        $('.table--data tr td:first-child input[type="checkbox"]').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
        });         
    }
});
$('#selecctall-banner').click(function(event) {  //on click 
    if(this.checked) { // check select status
        $('.banner-content-list li input[type="checkbox"]').each(function() { //loop through each checkbox
            this.checked = true;  //select all checkboxes with class "checkbox1"               
        });
    }else{
        $('.banner-content-list li input[type="checkbox"]').each(function() { //loop through each checkbox
            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
        });         
    }
});


/******* ACTION LIST *******/
$('.action>i').each(function(){
    $(this).click(function(){
        var element = $(this);
        
        if(element.parent().hasClass('open-action')){
           $('.action.open-action').removeClass('open-action');  
        }else{
            $('.action.open-action').removeClass('open-action');
        
            setTimeout(function(){
                element.parent('.action').toggleClass('open-action')
            },100)
        };
    });
});



/******* FILTER DROPDOWN *******/
$('.main-container__content__info__search__dropdown').change(function(){
    var choice = $(this).val();
    
    $('.main-container__content__info__search__option:visible').fadeOut(function(){
        $('#'+choice).fadeIn(function(){
            $('#'+choice).removeClass('hide')
        });
    });
})




/******* CHECK ALL SUB MODULES *******/
$('.editaccesscontrol__content__modules-list > li input[type="checkbox"]').change(function(e){
    e.stopPropagation();
    if(this.checked) { 
       $(this).parent('label').siblings('.sub-module_container').find('.sub-module_list > li input[type="checkbox"]').each(function(){
           $(this).prop('checked',true);
       });
    }else{
        $(this).parent('label').siblings('.sub-module_container').find('.sub-module_list > li input[type="checkbox"]').each(function(){
           $(this).prop('checked',false);
       });         
    }
});




/******* CHECK MAIN MODULES *******/
$('.sub-module_list > li input[type="checkbox"]').each(function(){
    $(this).change(function(e){
         e.stopPropagation();
        if(this.checked) { 
           $(this).parents('.sub-module_list').parent().siblings('label').find('input[type="checkbox"]').prop('checked',true);
        }else{
            if($(this).parents('.sub-module_list').find('input[type="checkbox"]:checked').length === 0){
                $(this).parents('.sub-module_list').parent().siblings('label').find('input[type="checkbox"]').prop('checked',false);   
            }
        }
    });
})


/******* UPLOAD PHOTO AND PREVIEW *******/
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        $('#blah').show();
        $('.upload-image-container__upload > .fa').show();
        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
        }
        $("#imgInp").hide();
        reader.readAsDataURL(input.files[0]);
    }
}

function readImage(file) {

    var reader = new FileReader();
    var image  = new Image();

    reader.readAsDataURL(file);  
    reader.onload = function(_file) {
        image.src    = _file.target.result;              // url.createObjectURL(file);
        image.onload = function() {
            var w = this.width,
                h = this.height,
                t = file.type.split('/')[1],                           // ext only: // file.type.split('/')[1],
                n = file.name,
                s = ((file.size/1024).toFixed(1)) +' kb';
                $('.file-type').text(t);
                $('.file-size').text(s);
                $('.file-dimension').text(w+'x'+h);
            console.log(w+'x'+h+' '+s+' '+t+' '+n);
        };
        image.onerror= function() {
            alert('Invalid file type: '+ file.type);
        };      
    };

}

$("#imgInp").change(function(){
    readURL(this);
    var F = this.files;
    if(F && F[0]) for(var i=0; i<F.length; i++){
        readImage( F[i] );
    }
});

$('#deleteimage').click(function(){
    $('#blah').attr('src','').hide().removeClass('show');
    $('.upload-image-container__upload > .fa').hide().removeClass('show');
    $("#imgInp").val('').show().removeClass('hide');
    $('.file-type').text("");
    $('.file-size').text("");
    $('.file-dimension').text("");
})
   
$('#editurlkey').click(function(){
    if($('#texturlkey').attr("disabled")){
        $('#texturlkey').toggleClass('textbox--editable').removeAttr("disabled");
        $('#editurlkey').text('Done');
    }else{
        $('#texturlkey').toggleClass('textbox--editable').attr("disabled",true);
        $('#editurlkey').text('Edit');
    }
    
});






/************ EDITOR MTREE ***********/

    // mtree.js
    // Requires jquery.js and velocity.js (optional but recommended).
    // Copy the below function, add to your JS, and simply add a list <ul class=mtree> ... </ul>
    ;(function ($, window, document, undefined) {

      // Only apply if mtree list exists
      if($('ul.mtree').length) { 


      // Settings
      var collapsed = true; // Start with collapsed menu (only level 1 items visible)
      var close_same_level = false; // Close elements on same level when opening new node.
      var duration = 400; // Animation duration should be tweaked according to easing.
      var listAnim = true; // Animate separate list items on open/close element (velocity.js only).
      var easing = 'easeOutQuart'; // Velocity.js only, defaults to 'swing' with jquery animation.


      // Set initial styles 
      $('.mtree ul').css({'overflow':'hidden', 'height': (collapsed) ? 0 : 'auto', 'display': (collapsed) ? 'none' : 'block' });

      // Get node elements, and add classes for styling
      var node = $('.mtree li:has(ul)');  
      node.each(function(index, val) {
        $(this).children(':first-child').css('cursor', 'pointer')
        $(this).addClass('mtree-node mtree-' + ((collapsed) ? 'closed' : 'open'));
        $(this).children('ul').addClass('mtree-level-' + ($(this).parentsUntil($('ul.mtree'), 'ul').length + 1));
      });

      // Set mtree-active class on list items for last opened element
      $('.mtree li > *:first-child').on('click.mtree-active', function(e){
        if($(this).parent().hasClass('mtree-closed')) {
          $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
          $(this).parent().addClass('mtree-active');
        } else if($(this).parent().hasClass('mtree-open')){
          $(this).parent().removeClass('mtree-active'); 
        } else {
          $('.mtree-active').not($(this).parent()).removeClass('mtree-active');
          $(this).parent().toggleClass('mtree-active'); 
        }
      });

      // Set node click elements, preferably <a> but node links can be <span> also
      node.children(':first-child').on('click.mtree', function(e){

        // element vars
        var el = $(this).parent().children('ul').first();
        var isOpen = $(this).parent().hasClass('mtree-open');

        // close other elements on same level if opening 
        if((close_same_level || $('.csl').hasClass('active')) && !isOpen) {
          var close_items = $(this).closest('ul').children('.mtree-open').not($(this).parent()).children('ul');

          // Velocity.js
          if($.Velocity) {
            close_items.velocity({
              height: 0
            }, {
              duration: duration,
              easing: easing,
              display: 'none',
              delay: 100,
              complete: function(){
                setNodeClass($(this).parent(), true)
              }
            });

          // jQuery fallback
          } else {
            close_items.delay(100).slideToggle(duration, function(){
              setNodeClass($(this).parent(), true);
            });
          }
        }

        // force auto height of element so actual height can be extracted
        el.css({'height': 'auto'}); 

        // listAnim: animate child elements when opening
        if(!isOpen && $.Velocity && listAnim) el.find(' > li, li.mtree-open > ul > li').css({'opacity':0}).velocity('stop').velocity('list');

        // Velocity.js animate element
        if($.Velocity) {
          el.velocity('stop').velocity({
            //translateZ: 0, // optional hardware-acceleration is automatic on mobile
            height: isOpen ? [0, el.outerHeight()] : [el.outerHeight(), 0]
          },{
            queue: false,
            duration: duration,
            easing: easing,
            display: isOpen ? 'none' : 'block',
            begin: setNodeClass($(this).parent(), isOpen),
            complete: function(){
              if(!isOpen) $(this).css('height', 'auto');
            }
          });

        // jQuery fallback animate element
        } else {
          setNodeClass($(this).parent(), isOpen);
          el.slideToggle(duration);
        }

        // We can't have nodes as links unfortunately
        e.preventDefault();
      });

      // Function for updating node class
      function setNodeClass(el, isOpen) {
        if(isOpen) {
          el.removeClass('mtree-open').addClass('mtree-closed');
        } else {
          el.removeClass('mtree-closed').addClass('mtree-open');
        }
      }

      // List animation sequence
      if($.Velocity && listAnim) {
        $.Velocity.Sequences.list = function (element, options, index, size) {
          $.Velocity.animate(element, { 
            opacity: [1,0],
            translateY: [0, -(index+1)]
          }, {
            delay: index*(duration/size/2),
            duration: duration,
            easing: easing
          });
        };
      }

        // Fade in mtree after classes are added.
        // Useful if you have set collapsed = true or applied styles that change the structure so the menu doesn't jump between states after the function executes.
        if($('.mtree').css('opacity') == 0) {
          if($.Velocity) {
            $('.mtree').css('opacity', 1).children().css('opacity', 0).velocity('list');
          } else {
            $('.mtree').show(200);
          }
        }
      }
    }(jQuery, this, this.document));


    /* DEMO STUFF */

      var mtree = $('ul.mtree');

      // Skin selector for demo
      mtree.wrap('<div class=mtree-demo></div>');
      var skins = ['bubba','skinny','transit','jet','nix'];
      mtree.addClass(skins[0]);
    /* $('body').prepend('<div class="mtree-skin-selector"><ul class="button-group radius"></ul></div>');
      var s = $('.mtree-skin-selector');
      $.each(skins, function(index, val) {
        s.find('ul').append('<li><button class="small skin">' + val + '</button></li>');
      });
      s.find('ul').append('<li><button class="small csl active">Close Same Level</button></li>');
      s.find('button.skin').each(function(index){
        $(this).on('click.mtree-skin-selector', function(){
          s.find('button.skin.active').removeClass('active');
          $(this).addClass('active');
          mtree.removeClass(skins.join(' ')).addClass(skins[index]);
        });
      })
      s.find('button:first').addClass('active');
      s.find('.csl').on('click.mtree-close-same-level', function(){
        $(this).toggleClass('active'); 
      });*/

/******** EDITOR ADD FOLDER *********/ 

var parentbutton;

//GET PARENT FOLDER NAME WHEN PLUS IS CLICKED
$('.btn-add-folder').click(function(){
    parentbutton = $(this);
    $('#folder-name').val("");
})

//ADD FOLDER ACTION
$('#add-folder-action').click(function(){
    var folder_name=$('#folder-name').val();
    var parent_folder=$(parentbutton).parent('li.has-submenu').attr('data-folder');
   
    
    var list = $("<li>", { class: "has-submenu mtree-node mtree-closed","data-folder":folder_name});
    var anchor=$('<a>',{href:"#"}).html(folder_name);
    var button = $('<button>',{type:'button',class:'btn fa fa-plus pull-right btn-add-folder',"data-toggle":'modal',"data-target":'#add-folder'})
    var option=$('<option>',{value:folder_name}).html(folder_name);
    
    $(list).append($(anchor),$(button));
    $(parentbutton).siblings('ul').append($(list));
    $('select#'+parent_folder).append($(option));
    $('#add-folder').modal('hide');
})

//HIDE AND SHOW THE DROPDOWNS
$("#folder-selector").change(function(){
    var optionvalue = $(this).val();
    $('.editor-action-holder .folder-drop:not(#'+optionvalue+',#added-file,#add-file)').fadeOut();
    setTimeout(function(){
        $('#'+optionvalue).fadeIn();
        $('#added-file').fadeIn();
        $('#add-file').fadeIn().css({display:'block'});
    },500);
})

//UPLOAD FILE ACTION
/*$('#add-file').click(function(){
    var filename = $('#added-file').val().replace(/C:\\fakepath\\/i, '');
    var parent_folder=$('#folder-selector').val();
    var sub_folder=$('select.folder-drop:visible').val();

    if($('li[data-folder="'+sub_folder+'"]').children('ul').length == 1){
        
    }else{
        var sub_ul=$("<ul>",{class:"mtree-level-2",style:"overflow: hidden; height: 0px; display: none"});
        var sub_ul_li = $("<li>");
        var sub_ul_li_anchor=$('<a>',{href:"#"}).html(filename);
        
        $(sub_ul_li).append($(sub_ul_li_anchor));
        $(sub_ul).append($(sub_ul_li));
        $('li[data-folder="'+sub_folder+'"]').append($(sub_ul));
    }
});*/
