/**
 * jQuery.Loading - 'Loading' messages made easy
 * @version   0.9.0.20131205
 * @author    biohzrdmx <github.com/biohzrdmx>
 * @requires  jQuery 1.8+
 * @license   MIT
 * @copyright Copyright © 2013 biohzrdmx. All rights reserved.
 */
;(function($){$.fn.loading=function(options){if(!this.length){return this}var isApiCall=typeof options==='string';var opts=$.extend(true,{},$.fn.loading.defaults,isApiCall?{}:options);this.each(function(){var fn=isApiCall?options:'loading';if($(this).is('button,a,input')){fn='button'}fn=$.fn.loading.api[fn];if($.isFunction(fn)){fn.call(this,opts)}});return this};$.fn.loading.api={loading:function(options){var el=$(this);var markup=options.markup.replace('{class}',options.className).replace('{text}',options.text);var overlay=$(markup);if(options.themeClass){overlay.addClass(options.themeClass)}if(options.emptyParent){el.empty()}overlay.hide();el.append(overlay);if(options.animate){overlay.fadeIn()}else{overlay.show()}},done:function(options){var el=$(this);var overlay=el.children().filter(function(index){return $(this).hasClass(options.className)});if(overlay.length){overlay.detach()}},button:function(options){var el=$(this);var prev=el.data('loading.button');if(prev){if(el.is('input')){el.val(prev)}else{el.text(prev)}el.prop({disabled:false});el.data('loading.button',null)}else{if(el.is('input')){prev=el.val();el.data('loading.button',prev);el.val(options.text)}else{prev=el.text();el.data('loading.button',prev);el.text(options.text)}el.prop({disabled:true})}}};$.fn.loading.defaults={text:'Loading...',className:'loading',themeClass:null,emptyParent:false,animate:false,markup:'<div class="{class}"></div>'}})(jQuery);

/**
 * jQuery Validator 3
 * @author     biohzrdmx <github.com/biohzrdmx>
 * @version    3.0.20131213
 * @requires   jQuery 1.8+
 * @license    MIT
 */
;(function($){$.fn.validate=function(options){if(!this.length){return this}var opts=$.extend(true,{},$.fn.validate.defaults,options);var result=false;this.each(function(){var form=$(this);if(form.is('form')){var rules=form.data('validator.rules');if(!rules){var fields=form.find('[data-validate]');rules=[];fields.each(function(index,el){el=$(el);rules.push({element:el,validator:el.data('validate'),param:el.data('param')||null})})}var fields=[];var error=0;if(rules){var rule,fn,ret;for(var i=0;i<rules.length;i++){rule=rules[i];fn=$.fn.validate.types[rule.validator];if(typeof fn==='function'){ret=fn.call(form,{element:rule.element,param:rule.param});if(!ret){error++;fields.push(rule.element)}}else{if((typeof console==='object')&&(typeof console.log==='function')){console.log('Unknown validator method: '+rule.validator)}}}}if(error>0){opts.error.call(form,$(fields))}else{opts.success.call(form);result=true}}});return result};$.fn.validate.types={required:function(options){var element=options.element||null;var param=options.param||null;if(element&&element.is(':visible')&&!element.is(':disabled')){var val=$.trim(element.val());if((element.is(':checkbox ')&&!element.is(':checked'))||(element.is(':radio')&&$('input[name='+element.attr('name')+']:checked').length==0)||(val=='')){return false}}return true},equal:function(options){var element=options.element||null;var param=options.param||null;var compare;if(element&&element.is(':visible')&&!element.is(':disabled')){if(typeof(param)=='string'){compare=$(param)}else{compare=param}if(compare===null||element.val()==''||element.val()!==compare.val()){return false}}return true},email:function(options){var element=options.element||null;var param=options.param||null;var regexp=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;if(element&&element.is(':visible')&&!element.is(':disabled')){return regexp.test(element.val())}return true},regexp:function(options){var element=options.element||null;var param=options.param||null;var regexp=new RegExp(param);if(element&&element.is(':visible')&&!element.is(':disabled')){return regexp.test(element.val())}return true},checked:function(options){var element=options.element||null;var param=options.param||null;if(element&&element.is(':visible')&&!element.is(':disabled')){var opts=param.match(/(at least|at most|exactly)\s([0-9]+)/);var opt=opts[1]||'exactly';var qty=opts[2]||1;var val=$('input[name='+element.attr('name')+']:checked').length;var ret=false;switch(opt){case'at least':ret=val>=qty;break;case'at most':ret=qty>=val;break;case'exactly':ret=val==qty}return ret}return true},date:function(options){var element=options.element||null;var params=options.param||null;if(element&&element.is(':visible')&&!element.is(':disabled')){var opts=params.match(/(before|after)\s([0-9]{4})\/([0-9]{1,2})\/([0-9]{1,2})/);var dateOpt=opts[1]||'before';var dateCheck=new Date(opts[2]||1900,--opts[3]||0,opts[4]||1);var dateValue=null;if(element.is('input')||element.is('textarea')){dateValue=new Date(element.val())}else{var components=element.find('[data-date]');switch(components.length){case 1:if($.fn.validate.types.required({element:element.find('[data-date="year"]')})){dateValue=new Date(element.find('[data-date="year"]').val()||1900)}break;case 2:if($.fn.validate.types.required({element:element.find('[data-date="year"]')})&&$.fn.validate.types.required({element:element.find('[data-date="month"]')})){dateValue=new Date(element.find('[data-date="year"]').val()||1900,element.find('[data-date="month"]').val()-1||0)}break;case 3:if($.fn.validate.types.required({element:element.find('[data-date="year"]')})&&$.fn.validate.types.required({element:element.find('[data-date="month"]')})&&$.fn.validate.types.required({element:element.find('[data-date="day"]')})){dateValue=new Date(element.find('[data-date="year"]').val()||1900,element.find('[data-date="month"]').val()-1||0,element.find('[data-date="day"]').val()||1)}}}var ret=false;if(dateValue)switch(dateOpt){case'before':ret=dateCheck>dateValue;break;case'after':ret=dateValue>dateCheck;break;case'exactly':ret=dateValue==dateCheck}return ret}return true},confirm:function(options){var element=options.element||null;var param=options.param||null;var compare;if(element&&!element.is(':disabled')){if(typeof(param)=='string'){compare=$(param)}else{compare=param}if(compare===null||(compare.val()!=''&&element.val()=='')||element.val()!==compare.val()){return false}}return true}};$.fn.validate.defaults={error:function(fields){},success:function(){}}})(jQuery);

/**
 * jQuery Alert
 * @author     biohzrdmx <github.com/biohzrdmx>
 * @version    1.0.20131213
 * @requires   jQuery 1.8+
 * @license    MIT
 */
;(function($){if(typeof $.easing.easeInOutQuad!=='function'){$.easing.easeInOutQuad=function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b}}$.alert=function(message,options){var opts=$.extend(true,{},$.alert.defaults,options);var alert=$(opts.markup.replace('{message}',message));var container=$(opts.container);var buttons=[];if(opts.onlyOne&&container.find('.alert-overlay').length>0){$.alert.close()}if(opts.themeClass){alert.addClass(opts.themeClass)}var buttonContainer=alert.find('.alert-buttons');buttonContainer.empty();$.each(opts.buttons,function(index,val){var button=$(opts.buttonMarkup);var key=opts.buttons[index].key||index;button.addClass('button-'+key);button.text(opts.buttons[index].text||'Close');button.on('click',opts.buttons[index].action||$.noop);buttonContainer.append(button)});var dialog=alert.find('.alert');alert.hide();container.append(alert);alert.fadeIn();opts.fnShow(dialog,opts.onOpen);alert.data('alert-opts',opts)};$.alert.close=function(){var alert=$('.alert-overlay');var dialog=alert.find('.alert');var opts=alert.data('alert-opts');var detachIt=function(){alert.detach();opts.onClose.call()};if(opts){opts.fnHide(dialog,function(){alert.fadeOut(detachIt)})}else{alert.fadeOut(detachIt)}};$.alert.defaults={container:'body',markup:'<div class="alert-overlay"><div class="alert"><div class="alert-message">{message}</div><div class="alert-buttons"></div></div></div>',buttonMarkup:'<button></button>',themeClass:'',onlyOne:true,buttons:[{text:'Close',action:function(){$.alert.close()}}],onOpen:$.noop,onClose:$.noop,fnShow:function(element,callback){element.css({opacity:0,marginTop:'-=40'});element.animate({opacity:1,marginTop:'+=40'},{duration:200,easing:'easeInOutQuad',complete:callback||$.noop})},fnHide:function(element,callback){element.animate({opacity:0,marginTop:'-=40'},{duration:200,easing:'easeInOutQuad',complete:callback||$.noop})}}})(jQuery);

/**
* jQuery DatePicker
* @author biohzrdmx <github.com/biohzrdmx>
* @version 1.0
* @requires jQuery 1.8+
* @license MIT
*/
;(function($){$.datePicker={strings:{monthsFull:['January','Febraury','March','April','May','June','July','August','September','October','November','December'],monthsShort:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],daysFull:['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],daysShort:['Su','Mo','Tu','We','Th','Fr','Sa']},defaults:{formatDate:function(date){var formatted=$.datePicker.utils.pad(date.getDate(),2)+'/'+$.datePicker.utils.pad(date.getMonth()+1,2)+'/'+date.getFullYear();return formatted},parseDate:function(string){var date=new Date();var parts=string.match(/(\d{1,2})\/(\d{1,2})\/(\d{4})/);if(parts&&parts.length==4){date=new Date(parts[3],parts[2]-1,parts[1])}return date},limitCenturies:true,closeOnPick:true},utils:{firstDay:function(year,month){return new Date(year,month,1).getDay()},daysInMonth:function(year,month){return new Date(year,++month,0).getDate()},buildDecadePicker:function(century,year){var obj=$.datePicker,decades=$('<div class="decades"></div>'),firstDecade=(Math.floor(century/100)*100)-10,limit=$.datePicker.defaults.limitCenturies;var header='<div class="row header">'+'<a href="#" class="prev'+(limit&&firstDecade<1900?' disabled':'')+'"><span class="arrow"></span></a>'+'<a href="#" class="century" data-century="'+(firstDecade+10)+'">'+(firstDecade+1)+'-'+(firstDecade+100)+'</a>'+'<a href="#" class="next'+(limit&&firstDecade==1990?' disabled':'')+'"><span class="arrow"></span></a>'+'</div>';decades.append(header);var n=0;var type='';var num=0;for(var i=0;i<3;i++){var row=$('<div class="row"></div>');for(var j=0;j<4;j++){n=j+(i*4);type=n==0?' grayed prev':(n==11?' grayed next':'');num=firstDecade+(n*10);if(limit&&(num<1900||num>2090)){var item=$('<a href="" class="cell large double decade blank">&nbsp;</a>');row.append(item);continue}if(year>=num&&year<=(num+9)){type+=' selected'}var item=$('<a href="#" data-year="'+num+'" class="cell large double decade'+type+'"><span>'+num+'- '+(num+9)+'</span></a>');row.append(item)};decades.append(row)};return decades},buildYearPicker:function(decade,year){var obj=$.datePicker,years=$('<div class="years"></div>'),firstYear=(Math.floor(decade/10)*10)-1,limit=$.datePicker.defaults.limitCenturies;var header='<div class="row header">'+'<a href="#" class="prev'+(limit&&firstYear==1899?' disabled':'')+'"><span class="arrow"></span></a>'+'<a href="#" class="decade" data-decade="'+(firstYear+1)+'">'+(firstYear+1)+'-'+(firstYear+10)+'</a>'+'<a href="#" class="next'+(limit&&firstYear==2089?' disabled':'')+'"><span class="arrow"></span></a>'+'</div>';years.append(header);var n=0;var type='';var num=0;for(var i=0;i<3;i++){var row=$('<div class="row"></div>');for(var j=0;j<4;j++){n=j+(i*4);type=n==0?' grayed prev':(n==11?' grayed next':'');num=firstYear+n;if(limit&&(num<1900||num>2099)){var item=$('<a href="" class="cell large year blank">&nbsp;</a>');row.append(item);continue}if(num==year){type+=' selected'}var item=$('<a href="#" data-year="'+num+'" class="cell large year'+type+'">'+num+'</a>');row.append(item)};years.append(row)};return years},buildMonthPicker:function(year,month){var obj=$.datePicker,months=$('<div class="months"></div>'),limit=$.datePicker.defaults.limitCenturies;var header='<div class="row header">'+'<a href="#" class="prev'+(limit&&year==1900?' disabled':'')+'"><span class="arrow"></span></a>'+'<a href="#" class="year" data-year="'+year+'">'+year+'</a>'+'<a href="#" class="next'+(limit&&year==2099?' disabled':'')+'"><span class="arrow"></span></a>'+'</div>';months.append(header);var n=0;var type='';for(var i=0;i<3;i++){var row=$('<div class="row"></div>');for(var j=0;j<4;j++){n=j+(i*4);type='';if(n==month){type+=' selected'}var item=$('<a href="#" data-year="'+year+'" data-month="'+n+'" class="cell large month'+type+'">'+obj.strings.monthsShort[n]+'</a>');row.append(item)};months.append(row)};return months},buildCalendar:function(year,month,selected){var obj=$.datePicker,calendar=$('<div class="calendar"></div>'),date=new Date(),year=year||date.getFullYear(),month=month>=0?month:date.getMonth(),temp=new Date(year,month,1),limit=$.datePicker.defaults.limitCenturies;temp.setDate(temp.getDate()-1);var lastPrev=temp.getDate(),lastCur=this.daysInMonth(year,month),offset=this.firstDay(year,month),numbering=1-offset;if(offset==0){numbering-=7}var header='<div class="row header">'+'<a href="#" class="prev'+(limit&&year==1900&&month==0?' disabled':'')+'"><span class="arrow"></span></a>'+'<a href="#" class="month" data-year="'+year+'" data-month="'+month+'">'+obj.strings.monthsFull[month]+' '+year+'</a>'+'<a href="#" class="next'+(limit&&year==2099&&month==11?' disabled':'')+'"><span class="arrow"></span></a>'+'</div>';calendar.append(header);var days=$('<div class="row days"></div>');for(var w=0;w<7;w++){days.append('<div class="cell">'+obj.strings.daysShort[w]+'</div>')}calendar.append(days);for(var w=0;w<6;w++){var week=$('<div class="row week"></div>');for(var d=0;d<7;d++){var num=numbering<=0?lastPrev+numbering:(numbering>lastCur?numbering-lastCur:numbering),type=numbering<=0?' grayed prev':(numbering>lastCur?' grayed next':'');if(limit&&(year==1900&&month==0&&numbering<1||year==2099&&month==11&&numbering>lastCur)){week.append('<a href="#" class="cell day blank">&nbsp;</a>');numbering++;continue}if(numbering==date.getDate()&&month==date.getMonth()&&year==date.getFullYear()){type+=' today'}if(numbering==selected.getDate()&&month==selected.getMonth()&&year==selected.getFullYear()){type+=' selected'}week.append('<a href="#" class="cell day'+type+'">'+num+'</a>');numbering++}calendar.append(week)};return calendar},pad:function(num,size){var s=num+"";while(s.length<size)s="0"+s;return s}},show:function(options){var opts=$.extend(true,{},$.datePicker.defaults,options);var datePicker=null,date=new Date();if(opts.element){if(typeof opts.element=='string'){opts.element=$(opts.element)}date=opts.parseDate(opts.element.val())}var selected={day:date.getDate(),month:date.getMonth(),year:date.getFullYear(),decade:date.getFullYear()};var calendar=$.datePicker.utils.buildCalendar(selected.year,selected.month,date),months=$.datePicker.utils.buildMonthPicker(selected.year,selected.month),years=$.datePicker.utils.buildYearPicker(selected.year,selected.year),decades=$.datePicker.utils.buildDecadePicker(selected.year,selected.year),datePicker=$('<div class="datepicker"><span class="tip"></span></div>');datePicker.append(calendar);datePicker.append(months);datePicker.append(years);datePicker.append(decades);$.datePicker.hide(true);if(opts.element){var offset=opts.element.offset();datePicker.css({left:offset.left+'px',top:offset.top+opts.element.outerHeight(true)+15+'px'})}datePicker.hide();$('body').append(datePicker);datePicker.fadeIn(150);datePicker.on('click','.calendar .day',function(e){e.preventDefault();var el=$(this),calendar=el.closest('.calendar');if(el.hasClass('blank')){return}calendar.find('.selected').removeClass('selected');el.addClass('selected');selected.day=parseInt(el.text())||1;if(el.hasClass('grayed')){if(el.hasClass('prev')){selected.year-=selected.month==0?1:0;selected.month=selected.month>0?selected.month-1:11}else if(el.hasClass('next')){selected.year+=selected.month==11?1:0;selected.month=selected.month<11?selected.month+1:0}}date.setDate(selected.day);date.setMonth(selected.month);date.setYear(selected.year);var formatted=opts.formatDate(date);$(opts.element).val(formatted);if(opts.closeOnPick&&!el.hasClass('grayed')){$.datePicker.hide()}});datePicker.on('click','.calendar .month',function(e){e.preventDefault();var el=$(this),calendar=el.closest('.calendar'),months=datePicker.children('.months'),picker=$.datePicker.utils.buildMonthPicker(selected.year,selected.month);months.replaceWith(picker);months=picker;calendar.fadeOut(150,function(){months.fadeIn(150)})});datePicker.on('click','.calendar .prev',function(e){e.preventDefault();var el=$(this),calendar=el.closest('.calendar'),current=calendar.find('.month'),month=current.data('month'),year=current.data('year');if(el.hasClass('disabled')){return}month=month-1;if(month<0){month=11;year--}selected.month=month;selected.year=year;replacement=$.datePicker.utils.buildCalendar(year,month,date);replacement.hide();calendar.after(replacement);calendar.fadeOut(150,function(){calendar.detach();replacement.fadeIn(150)})});datePicker.on('click','.calendar .next',function(e){e.preventDefault();var el=$(this),calendar=el.closest('.calendar'),current=calendar.find('.month'),month=current.data('month'),year=current.data('year');if(el.hasClass('disabled')){return}month=month+1;if(month>11){month=0;year++}selected.month=month;selected.year=year;replacement=$.datePicker.utils.buildCalendar(year,month,date);replacement.hide();calendar.after(replacement);calendar.fadeOut(150,function(){calendar.detach();replacement.fadeIn(150)})});datePicker.on('click','.months .month',function(e){e.preventDefault();var el=$(this),months=el.closest('.months'),month=el.data('month'),year=el.data('year'),calendar=datePicker.children('.calendar'),replacement=null;if(el.hasClass('blank')){return}months.find('.selected').removeClass('selected');el.addClass('selected');selected.month=month;replacement=$.datePicker.utils.buildCalendar(year,month,date);replacement.hide();calendar.replaceWith(replacement);months.fadeOut(150,function(){replacement.fadeIn(150)})});datePicker.on('click','.months .prev',function(e){e.preventDefault();var el=$(this),months=el.closest('.months'),current=months.find('.year'),year=current.data('year');if(el.hasClass('disabled')){return}year-=1;selected.year=year;replacement=$.datePicker.utils.buildMonthPicker(year,selected.month);replacement.hide();months.after(replacement);months.fadeOut(150,function(){months.detach();replacement.fadeIn(150)})});datePicker.on('click','.months .next',function(e){e.preventDefault();var el=$(this),months=el.closest('.months'),current=months.find('.year'),year=current.data('year');if(el.hasClass('disabled')){return}year+=1;selected.year=year;replacement=$.datePicker.utils.buildMonthPicker(year,selected.month);replacement.hide();months.after(replacement);months.fadeOut(150,function(){months.detach();replacement.fadeIn(150)})});datePicker.on('click','.months .year',function(e){e.preventDefault();var el=$(this),months=el.closest('.months'),years=datePicker.children('.years'),picker=$.datePicker.utils.buildYearPicker(selected.decade,selected.year);years.replaceWith(picker);years=picker;months.fadeOut(150,function(){years.fadeIn(150)})});datePicker.on('click','.years .year',function(e){e.preventDefault();var el=$(this),years=el.closest('.years'),year=el.data('year'),months=datePicker.children('.months'),replacement=null;if(el.hasClass('blank')){return}else if(el.hasClass('next')||el.hasClass('prev')){return}years.find('.selected').removeClass('selected');el.addClass('selected');selected.year=year;selected.decade=year;replacement=$.datePicker.utils.buildMonthPicker(year,selected.month);replacement.hide();months.replaceWith(replacement);years.fadeOut(150,function(){replacement.fadeIn(150)})});datePicker.on('click','.years .prev',function(e){e.preventDefault();var el=$(this),years=el.closest('.years'),current=years.find('.decade'),decade=current.data('decade');if(el.hasClass('disabled')){return}decade-=10;selected.decade=decade;replacement=$.datePicker.utils.buildYearPicker(decade,selected.year);replacement.hide();years.after(replacement);years.fadeOut(150,function(){years.detach();replacement.fadeIn(150)})});datePicker.on('click','.years .next',function(e){e.preventDefault();var el=$(this),years=el.closest('.years'),current=years.find('.decade'),decade=current.data('decade');if(el.hasClass('disabled')){return}decade+=10;selected.decade=decade;replacement=$.datePicker.utils.buildYearPicker(decade,selected.year);replacement.hide();years.after(replacement);years.fadeOut(150,function(){years.detach();replacement.fadeIn(150)})});datePicker.on('click','.years .decade',function(e){e.preventDefault();var el=$(this),years=el.closest('.years'),decades=datePicker.children('.decades');years.fadeOut(150,function(){decades.fadeIn(150)})});datePicker.on('click','.decades .decade',function(e){e.preventDefault();var el=$(this),decade=el.data('year'),decades=el.closest('.decades'),years=datePicker.children('.years'),replacement=null;if(el.hasClass('blank')){return}else if(el.hasClass('next')||el.hasClass('prev')){return}decades.find('.selected').removeClass('selected');el.addClass('selected');replacement=$.datePicker.utils.buildYearPicker(decade,selected.year);replacement.hide();years.replaceWith(replacement);decades.fadeOut(150,function(){replacement.fadeIn(150)})});datePicker.on('click','.decades .prev',function(e){e.preventDefault();var el=$(this),decades=el.closest('.decades'),current=decades.find('.century'),century=current.data('century');if(el.hasClass('disabled')){return}century-=100;replacement=$.datePicker.utils.buildDecadePicker(century,selected.decade);replacement.hide();decades.after(replacement);decades.fadeOut(150,function(){decades.detach();replacement.fadeIn(150)})});datePicker.on('click','.decades .next',function(e){e.preventDefault();var el=$(this),decades=el.closest('.decades'),current=decades.find('.century'),century=current.data('century');if(el.hasClass('disabled')){return}century+=100;replacement=$.datePicker.utils.buildDecadePicker(century,selected.decade);replacement.hide();decades.after(replacement);decades.fadeOut(150,function(){decades.detach();replacement.fadeIn(150)})});datePicker.on('click','.decades .century',function(e){e.preventDefault()});$(document).on('mouseup',function(e){if(!datePicker.is(e.target)&&datePicker.has(e.target).length===0){$(document).off('mouseup');$.datePicker.hide()}})},hide:function(force){var force=force||false,el=$('.datepicker');if(force){el.remove()}else{el.fadeOut(150,el.remove)}}};$.fn.datePicker=function(options){if(!this.length){return this}var opts=$.extend(true,{},$.datePicker.defaults,options);this.each(function(){var el=$(this),parent=el.parent(),button=parent.find('[data-toggle=datepicker]');if(!button.length){el.on('click',function(){$.datePicker.show({element:el})})}else{button.on('click',function(e){e.preventDefault();if($('.datepicker:visible').length){$.datePicker.hide()}else{$.datePicker.show({element:el})}})}});return this};$('[data-select=datepicker]').each(function(){var el=$(this);el.datePicker()})})(jQuery);

/*! jquery.cookie v1.4.1 | MIT */
;!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});

/**
 * Serialize object
 */
;(function($){$.fn.serializeObject=function(){var arrayData,objectData;arrayData=this.serializeArray();objectData={};$.each(arrayData,function(){var value;if(this.value!=null){value=this.value}else{value=''}if(objectData[this.name]!=null){if(!objectData[this.name].push){objectData[this.name]=[objectData[this.name]]}objectData[this.name].push(value)}else{objectData[this.name]=value}});return objectData}})(jQuery);