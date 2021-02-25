@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <input type="text" name="client" id="client" class="typeahead">
            <form class="form-inline" id="panel" role="form">
                <div class="row">

                        <div class="col-md-12" style="display: contents" id="field_wrapper">

                        </div>
                </div>


            </form>
        <div class="row">

            <div class="col-md-12">
                <button id="saveFacture" type="submit" style="display: none;" class="btn btn-success" >save factur</button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12" id="alert-body">
            </div>
            <div class="col-md-12">
                <div class="card mt-5">
                    <div class="card-header">
                        <div class="col-md-12">
                            <div class="card-title button">

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="data-table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Product Name</th>
                                <th>initial price</th>
                                <th>Quantity en stock</th>
                                <th>Transportation cost</th>
                                <th>selling price</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="table-content">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-add-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    {{ __('Add serials')}}
                    <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <form method="POST" name="Pform" id="ProductForm">
                    <input type="hidden" name="Product_id" id="Product_id">
                    <div class="modal-body">
                        <div id='alert' class='hide'></div>
                        <div class="modal-split" id="modal-split-1">
                            <div class="modal-body">
                                @csrf

                                <div class="form-group row">
                                    <label for="P_name" class="col-md-4 col-form-label text-md-right">{{ __('P_name') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_name"  type="text" class="form-control @error('P_name') is-invalid @enderror" name="P_name" value="{{ old('P_name') }}" required autocomplete="name"  autofocus>

                                        @error('P_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_count" class="col-md-4 col-form-label text-md-right">{{ __('P_count') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_count" type="number" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"   step="1" class="form-control @error('P_count') is-invalid @enderror" name="P_count" required autocomplete="P_count">

                                        @error('P_count')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="P_S_price" class="col-md-4 col-form-label text-md-right">{{ __('-P_S_price') }}</label>

                                    <div class="col-md-6">
                                        <input id="P_S_price" type="number" min="0" class="form-control @error('P_S_price') is-invalid @enderror" name="P_S_price" value="{{ old('P_S_price') }}" required autocomplete="P_S_price">

                                        @error('P_S_price')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-split" id="modal-split-2">
                            <div class="form-group row">

                            </div>
                        </div>
                        <!--
                            <div class="modal-split">
                                3
                            </div>
                        -->
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="add_to_pannel">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        function showAlert(message,type,one) {
            $('#'+one).html('<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">' +
                '  <strong>'+message+'</strong>' +
                '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '    <span aria-hidden="true">&times;</span>' +
                '  </button>' +
                '</div>');
            $('#'+one).show();
        }
        var table = $('#data-table').DataTable({
            "autoWidth": false,
            "processing": true,
            "serverSide": true,
            "ajax" : "{{ route('availableProduct') }}",
            "columns" : [
                { data: 'id', name: 'id' },
                { data: 'P_name', name: 'P_name' },
                { data: 'P_I_price', name: 'P_I_price' },
                { data: 'en_stock', name: 'en stock' },
                { data: 'P_T_cost', name: 'P_T_cost' },
                { data: 'P_S_price', name: 'P_S_price' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ]});
        $('body').on('click', '.addPanel', function () {
            $("#alert").hide();
            var Product_id = $(this).data('id');
            /*var id_count = $('[id=same]');
            if (id_count .length > 0){
                $('[id=same]').remove();
            }
            */
            $.ajax({
                url:"{{route('productId')}}",
                method:'get',
                data:{id:Product_id},
                dataType:'json',
                success:function(data)
                {

                    $('#myModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#Product_id').val(data.id);
                    $("#P_name").val(data.P_name);
                    $("#P_count").removeAttr("min");
                    $("#P_count").attr("min",1);
                    $("#P_count").attr("max",data.serials.length);
                    $("#P_S_price").attr('min',0);
                },error:function (error) {
                    console.log(error.responseText);
                }
            });
        });
        var fieldHTML2 = '<a href="javascript:void(0);" class="remove_button"><i class="fas fa-minus-square fa-2x ml-2 mt-2" style="color:#dc3545"></i></a></div>';

        $('#add_to_pannel').on('click',function(e){
            e.preventDefault();
            var data = $('#ProductForm').serializeArray();

            if(data[3].value <= parseInt($('#P_count').attr('max')) && data[3].value >= parseInt($('#P_count').attr('min')) ){
                $('#alert').hide();
                $('#ProductForm').trigger("reset");
                //add code with P_name , P_id P_count
                $('#field_wrapper').append('<div class="input-group m-3" id="same" >\n' +
                    '  <div class="input-group-append">\n' +
                    '    <span class="input-group-text">'+data[3].value+'</span>\n' +
                    '  </div>\n'+
                    '<input class="btn btn-dark" readonly name="field_name[]" data-' +
                    data[0].name+
                    '="'+
                    data[0].value+
                    '" data-'+data[3].name+'="'+
                    data[3].value+'"'+
                    '" data-'+data[4].name+'="'+
                    data[4].value+'"'+
                    ' value="'+
                    data[2].value
                    +'"'
                    + '/>'
                    +
                    '<div class="input-group-append">\n' +
                    '    <span class="input-group-text">'+data[3].value*data[4].value+' MAD </span>\n' +
                    '  </div>' +fieldHTML2 +
                    '</div>'); //Add field html
                $('#saveFacture').show();
                $('#closeModal').click();

            }
            else{
                showAlert('betwwn '+$('#P_count').attr('max')+' and '+ $('#P_count').attr('min') +' !','danger','alert');
            }
        });
        $('#field_wrapper').on('click', '.remove_button', function(e){

                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html

            var id_count = $('[id=same]');

            if (id_count.length == 0){
                $('#saveFacture').hide();
            }

        });
        $('#saveFacture').on('click',function (e) {
            e.preventDefault();
            var data2 = new Array();
            var data = new Array();
            $(':input','#panel').each(function(i, o){

                data2['product_id'] = o.dataset.product_id;
                data2['p_count'] = o.dataset.p_count;
                data2['p_s_price'] = o.dataset.p_s_price;
                data.push(data2);
            })
            console.log(data);

        });
        !function(a,b){"use strict";"undefined"!=typeof module&&module.exports?module.exports=b(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],function(a){return b(a)}):b(a.jQuery)}(this,function(a){"use strict";var b=function(c,d){this.$element=a(c),this.options=a.extend({},b.defaults,d),this.matcher=this.options.matcher||this.matcher,this.sorter=this.options.sorter||this.sorter,this.select=this.options.select||this.select,this.autoSelect="boolean"!=typeof this.options.autoSelect||this.options.autoSelect,this.highlighter=this.options.highlighter||this.highlighter,this.render=this.options.render||this.render,this.updater=this.options.updater||this.updater,this.displayText=this.options.displayText||this.displayText,this.source=this.options.source,this.delay=this.options.delay,this.$menu=a(this.options.menu),this.$appendTo=this.options.appendTo?a(this.options.appendTo):null,this.fitToElement="boolean"==typeof this.options.fitToElement&&this.options.fitToElement,this.shown=!1,this.listen(),this.showHintOnFocus=("boolean"==typeof this.options.showHintOnFocus||"all"===this.options.showHintOnFocus)&&this.options.showHintOnFocus,this.afterSelect=this.options.afterSelect,this.addItem=!1,this.value=this.$element.val()||this.$element.text()};b.prototype={constructor:b,select:function(){var a=this.$menu.find(".active").data("value");if(this.$element.data("active",a),this.autoSelect||a){var b=this.updater(a);b||(b=""),this.$element.val(this.displayText(b)||b).text(this.displayText(b)||b).change(),this.afterSelect(b)}return this.hide()},updater:function(a){return a},setSource:function(a){this.source=a},show:function(){var d,b=a.extend({},this.$element.position(),{height:this.$element[0].offsetHeight}),c="function"==typeof this.options.scrollHeight?this.options.scrollHeight.call():this.options.scrollHeight;if(this.shown?d=this.$menu:this.$appendTo?(d=this.$menu.appendTo(this.$appendTo),this.hasSameParent=this.$appendTo.is(this.$element.parent())):(d=this.$menu.insertAfter(this.$element),this.hasSameParent=!0),!this.hasSameParent){d.css("position","fixed");var e=this.$element.offset();b.top=e.top,b.left=e.left}var f=a(d).parent().hasClass("dropup"),g=f?"auto":b.top+b.height+c,h=a(d).hasClass("dropdown-menu-right"),i=h?"auto":b.left;return d.css({top:g,left:i}).show(),this.options.fitToElement===!0&&d.css("width",this.$element.outerWidth()+"px"),this.shown=!0,this},hide:function(){return this.$menu.hide(),this.shown=!1,this},lookup:function(b){if("undefined"!=typeof b&&null!==b?this.query=b:this.query=this.$element.val()||this.$element.text()||"",this.query.length<this.options.minLength&&!this.options.showHintOnFocus)return this.shown?this.hide():this;var d=a.proxy(function(){a.isFunction(this.source)?this.source(this.query,a.proxy(this.process,this)):this.source&&this.process(this.source)},this);clearTimeout(this.lookupWorker),this.lookupWorker=setTimeout(d,this.delay)},process:function(b){var c=this;return b=a.grep(b,function(a){return c.matcher(a)}),b=this.sorter(b),b.length||this.options.addItem?(b.length>0?this.$element.data("active",b[0]):this.$element.data("active",null),this.options.addItem&&b.push(this.options.addItem),"all"==this.options.items?this.render(b).show():this.render(b.slice(0,this.options.items)).show()):this.shown?this.hide():this},matcher:function(a){var b=this.displayText(a);return~b.toLowerCase().indexOf(this.query.toLowerCase())},sorter:function(a){for(var e,b=[],c=[],d=[];e=a.shift();){var f=this.displayText(e);f.toLowerCase().indexOf(this.query.toLowerCase())?~f.indexOf(this.query)?c.push(e):d.push(e):b.push(e)}return b.concat(c,d)},highlighter:function(a){var b=this.query;if(""===b)return a;var f,c=a.match(/(>)([^<]*)(<)/g),d=[],e=[];if(c&&c.length)for(f=0;f<c.length;++f)c[f].length>2&&d.push(c[f]);else d=[],d.push(a);var h,g=new RegExp(b,"g");for(f=0;f<d.length;++f)h=d[f].match(g),h&&h.length>0&&e.push(d[f]);for(f=0;f<e.length;++f)a=a.replace(e[f],e[f].replace(g,"<strong>$&</strong>"));return a},render:function(b){var c=this,d=this,e=!1,f=[],g=c.options.separator;return a.each(b,function(a,c){a>0&&c[g]!==b[a-1][g]&&f.push({__type:"divider"}),!c[g]||0!==a&&c[g]===b[a-1][g]||f.push({__type:"category",name:c[g]}),f.push(c)}),b=a(f).map(function(b,f){if("category"==(f.__type||!1))return a(c.options.headerHtml).text(f.name)[0];if("divider"==(f.__type||!1))return a(c.options.headerDivider)[0];var g=d.displayText(f);return b=a(c.options.item).data("value",f),b.find("a").html(c.highlighter(g,f)),g==d.$element.val()&&(b.addClass("active"),d.$element.data("active",f),e=!0),b[0]}),this.autoSelect&&!e&&(b.filter(":not(.dropdown-header)").first().addClass("active"),this.$element.data("active",b.first().data("value"))),this.$menu.html(b),this},displayText:function(a){return"undefined"!=typeof a&&"undefined"!=typeof a.name?a.name:a},next:function(b){var c=this.$menu.find(".active").removeClass("active"),d=c.next();d.length||(d=a(this.$menu.find("li")[0])),d.addClass("active")},prev:function(a){var b=this.$menu.find(".active").removeClass("active"),c=b.prev();c.length||(c=this.$menu.find("li").last()),c.addClass("active")},listen:function(){this.$element.on("focus",a.proxy(this.focus,this)).on("blur",a.proxy(this.blur,this)).on("keypress",a.proxy(this.keypress,this)).on("input",a.proxy(this.input,this)).on("keyup",a.proxy(this.keyup,this)),this.eventSupported("keydown")&&this.$element.on("keydown",a.proxy(this.keydown,this)),this.$menu.on("click",a.proxy(this.click,this)).on("mouseenter","li",a.proxy(this.mouseenter,this)).on("mouseleave","li",a.proxy(this.mouseleave,this)).on("mousedown",a.proxy(this.mousedown,this))},destroy:function(){this.$element.data("typeahead",null),this.$element.data("active",null),this.$element.off("focus").off("blur").off("keypress").off("input").off("keyup"),this.eventSupported("keydown")&&this.$element.off("keydown"),this.$menu.remove(),this.destroyed=!0},eventSupported:function(a){var b=a in this.$element;return b||(this.$element.setAttribute(a,"return;"),b="function"==typeof this.$element[a]),b},move:function(a){if(this.shown)switch(a.keyCode){case 9:case 13:case 27:a.preventDefault();break;case 38:if(a.shiftKey)return;a.preventDefault(),this.prev();break;case 40:if(a.shiftKey)return;a.preventDefault(),this.next()}},keydown:function(b){this.suppressKeyPressRepeat=~a.inArray(b.keyCode,[40,38,9,13,27]),this.shown||40!=b.keyCode?this.move(b):this.lookup()},keypress:function(a){this.suppressKeyPressRepeat||this.move(a)},input:function(a){var b=this.$element.val()||this.$element.text();this.value!==b&&(this.value=b,this.lookup())},keyup:function(a){if(!this.destroyed)switch(a.keyCode){case 40:case 38:case 16:case 17:case 18:break;case 9:case 13:if(!this.shown)return;this.select();break;case 27:if(!this.shown)return;this.hide()}},focus:function(a){this.focused||(this.focused=!0,this.options.showHintOnFocus&&this.skipShowHintOnFocus!==!0&&("all"===this.options.showHintOnFocus?this.lookup(""):this.lookup())),this.skipShowHintOnFocus&&(this.skipShowHintOnFocus=!1)},blur:function(a){this.mousedover||this.mouseddown||!this.shown?this.mouseddown&&(this.skipShowHintOnFocus=!0,this.$element.focus(),this.mouseddown=!1):(this.hide(),this.focused=!1)},click:function(a){a.preventDefault(),this.skipShowHintOnFocus=!0,this.select(),this.$element.focus(),this.hide()},mouseenter:function(b){this.mousedover=!0,this.$menu.find(".active").removeClass("active"),a(b.currentTarget).addClass("active")},mouseleave:function(a){this.mousedover=!1,!this.focused&&this.shown&&this.hide()},mousedown:function(a){this.mouseddown=!0,this.$menu.one("mouseup",function(a){this.mouseddown=!1}.bind(this))}};var c=a.fn.typeahead;a.fn.typeahead=function(c){var d=arguments;return"string"==typeof c&&"getActive"==c?this.data("active"):this.each(function(){var e=a(this),f=e.data("typeahead"),g="object"==typeof c&&c;f||e.data("typeahead",f=new b(this,g)),"string"==typeof c&&f[c]&&(d.length>1?f[c].apply(f,Array.prototype.slice.call(d,1)):f[c]())})},b.defaults={source:[],items:8,menu:'<ul class="typeahead dropdown-menu" role="listbox"></ul>',item:'<li><a class="dropdown-item" href="#" role="option"></a></li>',minLength:1,scrollHeight:0,autoSelect:!0,afterSelect:a.noop,addItem:!1,delay:0,separator:"category",headerHtml:'<li class="dropdown-header"></li>',headerDivider:'<li class="divider" role="separator"></li>'},a.fn.typeahead.Constructor=b,a.fn.typeahead.noConflict=function(){return a.fn.typeahead=c,this},a(document).on("focus.typeahead.data-api",'[data-provide="typeahead"]',function(b){var c=a(this);c.data("typeahead")||c.typeahead(c.data())})});

        $('#client').typeahead({
            source: function (query, result) {
                $.ajax({
                    url : "{{route('showClient')}}",
                    data : {
                        _token : $('[name="_token"]').val(),
                        val : query
                    },
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
                        console.log(data);
                        result($.map(data, function (item) {
                           console.log(item.P_name);
                            return item.P_name;

                        }));
                    },error:function (data) {
                            console.log(data);
                    }
                });
            }
        });
    </script>
@stop
