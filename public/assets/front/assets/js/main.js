$(function () {
    
    // SELECTORs
    var SELECTOR = {
        header: '#header',
        form: 'form',
        formControl: '.form-control',
        submitButton: '.submitButton',
        menuHamburgerIcon: '.menu-hamburger-icon',
        menuCloseBtn: '.menu-close-btn',
        widgetTitle: '.widgetTitle',
        mainNav: '#main-nav',
        mainNavLink: '#main-nav a',
        subMenu: '.sub-menu',
        inputFile: 'input[type="file"]',
        clientHeader: '#client-header',
    };
    var w_width = $(document).width();

    // --------------------- Common - [Start]
    var COMMON = {
        validateForm: function(thisElement, e){
            var form = thisElement.closest('form');
            if (form[0].checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.addClass('was-validated');
        },

        clientHamburger: function(){
            $(SELECTOR.clientHeader + ' .hamburger').on('click', function(e){
                e.preventDefault();
                $('#client-nav').addClass('open');
            });
            $(SELECTOR.clientHeader + ' .close-btn').on('click', function(e){
                e.preventDefault();
                $('#client-nav').removeClass('open');
            });
        },
        
        // Handling hamburger menu
        closeMainNav: function(){
            $(SELECTOR.header).removeClass('menuOpened');
        },
        openMainNav: function(){
            $(SELECTOR.menuHamburgerIcon).on('click', function(){
                if($(SELECTOR.header).hasClass('menuOpened')){
                    COMMON.closeMainNav();
                } else {
                    $(SELECTOR.header).addClass('menuOpened');
                }
            })
        },
        // Handling submit button for all forms
        updateSubmitButton: function(){
            $(SELECTOR.form).each(function(index){
                var thisForm = $(this),
                    isValid = thisForm[0].checkValidity();
                if(isValid){
                    thisForm.find('[type="submit"]').removeAttr('disabled');
                } else {
                    thisForm.find('[type="submit"]').attr('disabled');
                }
            })
        },
        readURL: function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        },

        updateActiveNav: function(){
            var page = $('#main').data('page');
            $('a[href="' + page + '.php"]').closest('li').addClass('active');
        },
        responsiveTable: function(){
            if($('.tbl-responsive').length > 0){
                $('.tbl-responsive thead th').each(function(index, element){
                    var getTHIndex = $(this).index();
                    var dataTH = $(this).html();
                    
                    $(this).closest('.tbl-responsive').find('tbody td').each(function(index, element){	
                        var getTDIndex = $(this).index();
                        
                        if(getTDIndex == getTHIndex){
                            $(this).prepend('<span class="mb-label d-block d-sm-none">'+dataTH+'</span>');
                        }
                    });
                });
            }
        },
        mainMenuMobile: function(){
            $(SELECTOR.subMenu + ' li.active').closest(SELECTOR.subMenu).slideDown().closest('li').addClass('open-menu');
            $(SELECTOR.mainNavLink).on('click', function(e){
                var thisSubmenu = $(this).closest('li').find(SELECTOR.subMenu);
                if(thisSubmenu.length){
                    e.preventDefault();
                    $(this).closest('li').toggleClass('open-menu');
                    thisSubmenu.slideToggle();
                }
            })
        },
        customSelectDropdown: function(){
            $('select').wrap();
        },
        // On page load
        init: function(){
            // Default initialization - [Start]
            COMMON.openMainNav();
            COMMON.updateActiveNav();
            COMMON.mainMenuMobile();

            COMMON.updateSubmitButton();
            COMMON.responsiveTable();
            
            COMMON.clientHamburger();
            COMMON.customSelectDropdown();
            // Default initialization - [/end]
            
            
            $(SELECTOR.menuCloseBtn).on('click', function(){
                COMMON.closeMainNav();
            });

            // Validate Form on submit click
            $(SELECTOR.submitButton).on('click', function(e){
                //alert(21321);
                COMMON.validateForm($(this), e);
            });

            $(SELECTOR.formControl).on('keyup change', function(thisElement){
                COMMON.updateSubmitButton($(this));
            })

            $('[type="file"]').on('change', function(){
                var file = $(this).prop('files')[0];
                if (file) {
                    var imagen = URL.createObjectURL(file);
                    $(this).closest('.upload-box').find('.uploaded-file').removeClass('dp-none').attr('src', imagen);
                }
            });

            $('.order_found_btn').on('click', function(){
                $('.orders_assign_wrap').addClass('active');
            })
            
            $('.orders_assign_wrap .back_btn').on('click', function(e){
                e.preventDefault();
                $('.orders_assign_wrap').removeClass('active');
            })

            $('.forgot-pwd').on('click', function(){
                
            })

        }
    }
    // --------------------- Page Login - [Start]
    var PAGE_LOGIN = {
        init: function(){
            
        }
    }
    // --------------------- Page Login - [/end]
    
    // --------------------- Page Dispatcher - [Start]
    var PAGE_DISPATCHER = {
        joeySelect2Single: function(){
            $(".joey_select2").select2({
                // width: 'resolve' // need to override the changed default
                dropdownParent: $('#transferJoeySprint')
            });
        },

        joeySelect2Multiple: function(){
            $(".joey_select2_multiple").select2({
                // width: 'resolve' // need to override the changed default
                dropdownParent: $('#exclusive')
            });
        },
        init: function(){
            PAGE_DISPATCHER.joeySelect2Single();
            PAGE_DISPATCHER.joeySelect2Multiple();
        }
    }
    // --------------------- Page Dispatcher - [/end]
    
    // --------------------- Mobile - [Start]
    var MOBILE = {
        sidebarWidget: function(){
            $(SELECTOR.widgetTitle).on('click', function(){
                $(this).closest('.widget_sidebar').find('.widgetInfo').slideToggle('fast');
            })
        },
        init: function(){
            MOBILE.sidebarWidget();
        }
    };
    // --------------------- Mobile - [/end]
    
    COMMON.init()
    
    if(w_width <= 768){
        MOBILE.init();
    }
    
    PAGE_LOGIN.init();
    PAGE_DISPATCHER.init();
});