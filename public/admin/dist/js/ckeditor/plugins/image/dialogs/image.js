/*
 Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    var a = function (b, c) {
        var d = 1,
            e = 2,
            f = 4,
            g = 8,
            h = /^\s*(\d+)((px)|\%)?\s*$/i,
            i = /(^\s*(\d+)((px)|\%)?\s*$)|^$/i,
            j = /^\d+px$/,
            k = function () {
                var C = this.getValue(),
                    D = this.getDialog(),
                    E = C.match(h);
                if (E) {
                    if (E[2] == '%') p(D, false);
                    C = E[1];
                }
                if (D.lockRatio) {
                    var F = D.originalElement;
                    if (F.getCustomData('isReady') == 'true') if (this.id == 'txtHeight') {
                        if (C && C != '0') C = Math.round(F.$.width * (C / F.$.height));
                        if (!isNaN(C)) D.setValueOf('info', 'txtWidth', C);
                    } else {
                        if (C && C != '0') C = Math.round(F.$.height * (C / F.$.width));
                        if (!isNaN(C)) D.setValueOf('info', 'txtHeight', C);
                    }
                }
                l(D);
            },
            l = function (C) {
                if (!C.originalElement || !C.preview) return 1;
                C.commitContent(f, C.preview);
                return 0;
            };

        function m() {
            var C = arguments,
                D = this.getContentElement('advanced', 'txtdlgGenStyle');
            D && D.commit.apply(D, C);
            this.foreach(function (E) {
                if (E.commit && E.id != 'txtdlgGenStyle') E.commit.apply(E, C);
            });
        }

        ;
        var n;
        var img_template;
        function o(C) {
            if (n) return;
            n = 1;
            var D = this.getDialog(),
                E = D.imageElement;

            img_template = $(E.$);
            if (E) {
                this.commit(d, E);
                C = [].concat(C);
                var F = C.length,
                    G;
                for (var H = 0; H < F; H++) {
                    G = D.getContentElement.apply(D, C[H].split(':'));
                    G && G.setup(d, E);
                }
            }
            n = 0;
        }

        ;
        var p = function (C, D) {
                if (!C.getContentElement('info', 'ratioLock')) return null;
                var E = C.originalElement;
                if (!E) return null;
                if (D == 'check') {
                    if (!C.userlockRatio && E.getCustomData('isReady') == 'true') {
                        var F = C.getValueOf('info', 'txtWidth'),
                            G = C.getValueOf('info', 'txtHeight'),
                            H = E.$.width * 1000 / E.$.height,
                            I = F * 1000 / G;
                        C.lockRatio = false;
                        if (!F && !G) C.lockRatio = true;
                        else if (!isNaN(H) && !isNaN(I)) if (Math.round(H) == Math.round(I)) C.lockRatio = true;
                    }
                } else if (D != undefined) C.lockRatio = D;
                else {
                    C.userlockRatio = 1;
                    C.lockRatio = !C.lockRatio;
                }
                var J = CKEDITOR.document.getById(w);
                if (C.lockRatio) J.removeClass('cke_btn_unlocked');
                else J.addClass('cke_btn_unlocked');
                J.setAttribute('aria-checked', C.lockRatio);
                if (CKEDITOR.env.hc) {
                    var K = J.getChild(0);
                    K.setHtml(C.lockRatio ? CKEDITOR.env.ie ? '■' : '▣' : CKEDITOR.env.ie ? '□' : '▢');
                }
                return C.lockRatio;
            },
            q = function (C) {
                var D = C.originalElement;
                if (D.getCustomData('isReady') == 'true') {
                    var E = C.getContentElement('info', 'txtWidth'),
                        F = C.getContentElement('info', 'txtHeight');
                    //change nguyenlocvu
                    if(img_template.hasClass('img_template')){
                        D.$.width = E.getValue();
                        D.$.height = F.getValue();
                    }else{
                        /*alert(1);
                        if(D.$.width > 500){//resize theo value ban dau
                            alert(2);
                            D.$.height = Math.round( D.$.height * ( 500  / D.$.width ) );
                            D.$.width = 500;
                        }*/
                    }
                    // end change
                    E && E.setValue(D.$.width);
                    F && F.setValue(D.$.height);
                }
                l(C);
            },
            r = function (C, D) {
                if (C != d) return;

                function E(J, K) {
                    var L = J.match(h);
                    if (L) {
                        if (L[2] == '%') {
                            L[1] += '%';
                            p(F, false);
                        }
                        return L[1];
                    }
                    return K;
                }

                ;
                var F = this.getDialog(),
                    G = '',
                    H = this.id == 'txtWidth' ? 'width' : 'height',
                    I = D.getAttribute(H);
                if (I) G = E(I, G);
                G = E(D.getStyle(H), G);
                this.setValue(G);
            },
            s, t = function () {
                var C = this.originalElement;
                C.setCustomData('isReady', 'true');
                C.removeListener('load', t);
                C.removeListener('error', u);
                C.removeListener('abort', u);
                CKEDITOR.document.getById(y).setStyle('display', 'none');
                if (!this.dontResetSize) q(this);
                if (this.firstLoad) CKEDITOR.tools.setTimeout(function () {
                    p(this, 'check');
                }, 0, this);
                this.firstLoad = false;
                this.dontResetSize = false;
            },
            u = function () {
                var E = this;
                var C = E.originalElement;
                C.removeListener('load', t);
                C.removeListener('error', u);
                C.removeListener('abort', u);
                var D = CKEDITOR.getUrl(b.skinPath + 'images/noimage.png');
                if (E.preview) E.preview.setAttribute('src', D);
                CKEDITOR.document.getById(y).setStyle('display', 'none');
                p(E, false);
            },
            v = function (C) {
                return CKEDITOR.tools.getNextId() + '_' + C;
            },
            w = v('btnLockSizes'),
            x = v('btnResetSize'),
            y = v('ImagePreviewLoader'),
            z = v('ImagePreviewBox'),
            A = v('previewLink'),
            B = v('previewImage');
        return {
            title:b.lang.image[c == 'image' ? 'title' : 'titleButton'],
            minWidth:460,
            minHeight:370,
            onShow:function () {
                var I = this;
                I.imageElement = false;
                I.linkElement = false;
                I.imageEditMode = false;
                I.linkEditMode = false;
                I.lockRatio = false;
                I.userlockRatio = 0;
                I.dontResetSize = false;
                I.firstLoad = true;
                I.addLink = false;

                var C = I.getParentEditor(),
                    D = I.getParentEditor().getSelection(),
                    E = D.getSelectedElement();
                if (E != null) {
                    if (E.getName() == 'table') {
                        E = E.getElementsByTag('img').getItem(0);
                    }
                }
                var F = E && E.getAscendant('a');

                CKEDITOR.document.getById(y).setStyle('display', 'none');
                s = new CKEDITOR.dom.element('img', C.document);
                I.preview = CKEDITOR.document.getById(B);
                I.originalElement = C.document.createElement('img');
                I.originalElement.setAttribute('alt', '');
                I.originalElement.setCustomData('isReady', 'false');
                if (F) {
                    I.linkElement = F;
                    I.linkEditMode = true;
                    var G = F.getChildren();
                    if (G.count() == 1) {
                        var H = G.getItem(0).getName();
                        if (H == 'img' || H == 'input') {
                            I.imageElement = G.getItem(0);
                            if (I.imageElement.getName() == 'img') I.imageEditMode = 'img';
                            else if (I.imageElement.getName() == 'input') I.imageEditMode = 'input';
                        }
                    }
                    if (c == 'image') I.setupContent(e, F);
                }
                if (E && E.getName() == 'img' && !E.data('cke-realelement') || E && E.getName() == 'input' && E.getAttribute('type') == 'image') {
                    I.imageEditMode = E.getName();
                    I.imageElement = E;
                }
                if (I.imageEditMode) {
                    I.cleanImageElement = I.imageElement;
                    I.imageElement = I.cleanImageElement.clone(true, true);
                    I.setupContent(d, I.imageElement);
                } else I.imageElement = C.document.createElement('img');
                p(I, true);
                if (!CKEDITOR.tools.trim(I.getValueOf('info', 'txtUrl'))) {
                    I.preview.removeAttribute('src');
                    I.preview.setStyle('display', 'none');
                }
                this.getContentElement("info","txtWidthTrue").disable();
            },
            onOk:function () { //change dienth
                var D = this,
                    C_editor = D.getParentEditor(),
                    select_item = D.getParentEditor().getSelection(),
                    E_elem = select_item.getSelectedElement(),
                    elem_editor = $(C_editor.document.getBody().$),//get element editor
                    count_tbl = 0,
                    count_p = 0,
                    selected_ranges = select_item.getRanges(),
                    node = selected_ranges[0].startContainer,
                    parents = node.getParents(true),
                    style_p = 'align="center"',
                    style_table = 'text-align:center';
                var verBlock = false;
                if (elem_editor.hasClass('body_block_widget')) {
                    verBlock = true;
                }
                for(var i=0;i<elem_editor.find('table.tplCaption').length;i++){
                    count_tbl += 1;
                }
                for(var i=0;i<elem_editor.find('p.imgP').length;i++){
                    count_p += 1;
                }
                var caption = (D.getContentElement('info', 'txtCaption').getValue());

                if (D.imageEditMode) {
                    var C = D.imageEditMode;
                    if (c == 'image' && C == 'input' && confirm(b.lang.image.button2Img)) {
                        C = 'img';
                        D.imageElement = b.document.createElement('img');
                        D.imageElement.setAttribute('alt', '');
                        b.insertElement(D.imageElement);
                    } else if (c != 'image' && C == 'img' && confirm(b.lang.image.img2Button)) {
                        C = 'input';
                        D.imageElement = b.document.createElement('input');
                        D.imageElement.setAttributes({
                            type:'image',
                            alt:''
                        });
                        b.insertElement(D.imageElement);
                    } else {
                        D.imageElement = D.cleanImageElement;
                        delete D.cleanImageElement;
                    }
                } else {
                    if (c == 'image') D.imageElement = b.document.createElement('img');
                    else {
                        D.imageElement = b.document.createElement('input');
                        D.imageElement.setAttribute('type', 'image');
                    }
                    D.imageElement.setAttribute('alt', '');
                }
                if (!D.linkEditMode) D.linkElement = b.document.createElement('a');
                D.commitContent(d, D.imageElement);
                D.commitContent(e, D.linkElement);
                if (!D.imageElement.getAttribute('style')) D.imageElement.removeAttribute('style');

                if (D.imageEditMode == 'img') {
                    //////////////edit image
                    var image = D.imageElement.$;
                    image.setAttribute('data-natural-width',image.naturalWidth);
                    if(!($(image).parent().is('p')) && !($(image).parent().is('td'))){
                        if(!($(image).parent().is('a'))){
                            var parent_img = b.document.createElement('p');
                            $(parent_img.$).attr('text-align','center');
                            b.insertElement(parent_img);
                            $(parent_img.$).append(image);
                        }
                    }

                    var parent_node = $(image).parent();
                    if(this.getValueOf('info','attr_img') == false){
                        image.removeAttribute('data-zoom');
                    }else{
                        image.setAttribute('data-zoom','1');
                    }
                    if(this.getValueOf('info','attr_price') == ''){
                        image.removeAttribute('data-component-price');
                    }else{
                        image.setAttribute('data-component-price',this.getValueOf('info','attr_price'));
                    }
                    if(!(parent_node.closest('table').hasClass('tplCaption')) && !(parent_node.is('p'))){
                        //remove format
                        if(caption == ''){
                            var repl_p = $('<div><p align="center" class="imgP" id="dataimg'+ count_p +'"></p></div>');
                            repl_p.find('p').html($(image));
                            parent_node.parents('table').replaceWith(repl_p.html());
                        }else{
                            parent_node.html($(image));
                            parent_node.closest('table').find('td:eq(1) p').text(caption);
                        }
                        //end remove format

                    }else{
                        if (parent_node.is('td')) {
                            if (caption == '') {
                                var repl_p = $('<div><p align="center" class="imgP" id="dataimg'+ count_p +'"></p></div>');
                                repl_p.find('p').html($(image));
                                parent_node.parents('table').replaceWith(repl_p.html());
                            } else {
                                if(parent_node.parents('table').find('td:eq(1)').length == 0){
                                    parent_node.parents('table').append('<tr><td><p class="Image">[Caption]</p></td></tr>');
                                }
                                parent_node.parents('table').find('td:eq(1)').children().is('font,a') ? parent_node.parents('table').find('td:eq(1)').find('font,a').text(caption) : parent_node.parents('table').find('td:eq(1) p').html(caption);
                                var atr = (D.getContentElement('info', 'txtAlt').getValue());
                                if(atr == ''){
                                    parent_node.parents('table').find('img').attr('alt',caption);
                                }else{
                                    parent_node.parents('table').find('img').attr('alt',atr);
                                }
                            }
                        }else {
                            var tbl_wrap;
                            var idTable = parent_node.closest('table').attr('id');
                            if(parent_node.is('p') && caption == '' && parent_node.parent().is('td')){
                                parent_node.css('text-align','center');
                                parent_node.html($(image));
                                parent_node.closest('table').replaceWith(parent_node);
                            }else if(parent_node.is('table') && caption != ''){
                                parent_node.find('td:eq(0)').html($(image));
                            }else if(parent_node.parent().is('td') && caption != ''  || parent_node.parent().is('td') && caption == ''){
                                if(!(parent_node.is('a')) && !(idTable && idTable.match('template') != null)){
                                    parent_node.html($(image));
                                    parent_node.closest('table').find('td:eq(1) p').text(caption);
                                }
                            }
                            else{
                                var childNodeItem = parent_node.children().length,
                                    $img_move = parent_node.find('img'),
                                    $divWrap = $('<p class="imgP"></p>'),$itemTemp;
                                if(parent_node.text() != '' && childNodeItem == 1){
                                    parent_node.find('br').remove();
                                    var pWrap = $('<p class="Normal">'+parent_node.text()+'</p>');
                                    pWrap.insertAfter(parent_node);
                                }
                                if(childNodeItem > 1){
                                    parent_node.find('br').remove();
                                    $itemTemp = parent_node.clone();
                                    $itemTemp.removeAttr('id').removeAttr('class');
                                    $itemTemp.find('img').remove();
                                    parent_node.children().remove();
                                    $itemTemp.insertAfter(parent_node);
                                }
                                if (caption == '') {
                                    if(parent_node.is('p')){
                                        parent_node.html($(image));
                                        this.hide();
                                        return false;
                                    }else{
                                        tbl_wrap = $('<div><p align="center" class="imgP" id="dataimg'+ count_p +'"></p></div>');
                                        tbl_wrap.find('p').append($(image));
                                        tbl_wrap = tbl_wrap.html();
                                    }
                                } else {
                                    tbl_wrap = $('<div><table border="0" cellpadding="2" width="1" cellspacing="0" align="center" class="tplCaption" id="tblimg'+ count_tbl +'"><tr><td></td></tr><tr><td><p class="Image">[Caption]</p></td></tr></table></div>');
                                    tbl_wrap.find('td:eq(0)').css('text-align','center').append($(image));
                                    tbl_wrap.find('td:eq(1) p').text(caption);
                                    tbl_wrap = tbl_wrap.html();
                                }
                                parent_node.replaceWith(tbl_wrap);
                            }
                        }
                    }

                } else {
                    ////////////////insert image
                    var image = D.imageElement.$, table,
                        data_zoom = this.getValueOf('info','attr_img'),
                        attr_price = this.getValueOf('info','attr_price'),
                        atr = this.getValueOf('info','txtAlt');
                    if(data_zoom){
                        D.imageElement.setAttribute('data-zoom','1');
                    }
                    if(attr_price != 0){
                        D.imageElement.setAttribute('data-component-price', attr_price);

                    }
                    if(atr == ''){
                        $(image).attr('alt', caption);
                    }else{
                        $(image).attr('alt', atr);
                    }
                    if (caption == '') {
                        if($(node.$).is('td')){
                            $(node.$.parentNode).parents('table').find('td:eq(0)').html($(image));
                            this.hide();
                            return false;
                        }else{
                            table = $('<div><p align="center" class="imgP" id="dataimg'+ count_p +'"></p></div>');
                            table.find('p').append($(image));
                            table = table.html();
                        }
                    } else {
                        $(image).attr('title', caption);
                        $(image).css({
                            padding:0,
                            margin:0
                        });
                        if($(node.$).is('td')){
                            $(node.$).append($(image));
                            $(node.$).parents('table').find('td:eq(1)').text(caption);
                            this.hide();
                            return false;
                        }else{
                            table = $('<div><table border="0" cellpadding="3" width="1" cellspacing="0" align="center" class="tplCaption" id="tblimg'+ count_tbl +'"><tr><td></td></tr><tr><td class="Image"></td></tr></table></div>');
                            table.find('td:eq(0)').css('text-align','center').append($(image));//'<img width="'+ $(image).width() +'" src="' + $(image).attr('src') + '" alt="' + $(image).attr('alt') + '">'
                            table.find('td.Image').text(caption);
                            table = table.html();
                        }
                    }
                }
                if (!D.imageEditMode) {
                    if (D.addLink) {
                        /*if (!D.linkEditMode) {
                            b.insertElement(D.linkElement);
                            D.linkElement.insertHtml(table);
                        } else {
                            b.insertHtml(table);
                        }*/
                    } else {
                        b.insertHtml(table);
                        if($.browser.webkit == true){
                        if(node.$.textContent != '' && $(table).is('p')){
                            $(table).append($(node.$.parentNode).find('img'));
                            $(node.$.parentNode).find('img').remove();
                            $(table).insertAfter($(node.$.parentNode));
                        }
                        }
                        if(elem_editor.find('#dataimg'+count_p).parent().is('p') || elem_editor.find('#tblimg'+count_tbl).parent().is('p')){
                            elem_editor.find('#dataimg'+ count_p).parent('p').replaceWith(table);
                        }
                        if(elem_editor.find('table#tblimg'+ count_tbl).parent('p').text() != ''){
                            elem_editor.find('table#tblimg'+ count_tbl).parent('p').replaceWith(table);
                        }
                        if(elem_editor.find('table#tblimg'+ count_tbl).parent().is('td')){
                            var test = $('<p></p>'),
                                img_insert = elem_editor.find('table#tblimg'+ count_tbl).find('img'),
                                caption_insert = elem_editor.find('table#tblimg'+ count_tbl).find('td:eq(1)').text();
                            test.append(img_insert);
                            elem_editor.find('table#tblimg'+ count_tbl).parents('table').find('td.Image').text(caption_insert);
                            elem_editor.find('table#tblimg'+ count_tbl).replaceWith(test);
                        }
                    }
                } /*else if (!D.linkEditMode && D.addLink) {
                    b.insertElement(D.linkElement);
                    D.linkElement.insertHtml(table);
                } else if (D.linkEditMode && !D.addLink) {
                    b.getSelection().selectElement(D.imageElement);
                    b.insertHtml(table);
                }*/


                //end change dienth
            },
            onLoad:function () {
                var D = this;
                if (c != 'image') D.hidePage('Link');
                var C = D._.element.getDocument();
                if (D.getContentElement('info', 'ratioLock')) {
                    D.addFocusable(C.getById(x), 5);
                    D.addFocusable(C.getById(w), 5);
                }
                D.commitContent = m;
            },
            onHide:function () {
                var C = this;
                if (C.preview) C.commitContent(g, C.preview);
                if (C.originalElement) {
                    C.originalElement.removeListener('load', t);
                    C.originalElement.removeListener('error', u);
                    C.originalElement.removeListener('abort', u);
                    C.originalElement.remove();
                    C.originalElement = false;
                }
                delete C.imageElement;
            },
            contents:[
                {
                    id:'info',
                    label:b.lang.image.infoTab,
                    accessKey:'I',
                    elements:[
                        {
                            type:'vbox',
                            padding:0,
                            children:[
                                {
                                    type:'hbox',
                                    widths:['280px', '110px'],
                                    align:'right',
                                    children:[
                                        {
                                            id:'txtUrl',
                                            type:'text',
                                            label:b.lang.common.url,
                                            required:true,
                                            onChange:function () {
                                                var C = this.getDialog(),
                                                    D = this.getValue();
                                                if (D.length > 0) {
                                                    C = this.getDialog();
                                                    var E = C.originalElement;
                                                    C.preview.removeStyle('display');
                                                    E.setCustomData('isReady', 'false');
                                                    var F = CKEDITOR.document.getById(y);
                                                    if (F) F.setStyle('display', '');
                                                    E.on('load', t, C);
                                                    E.on('error', u, C);
                                                    E.on('abort', u, C);
                                                    E.setAttribute('src', D);
                                                    s.setAttribute('src', D);
                                                    C.preview.setAttribute('src', s.$.src);
                                                    l(C);
                                                } else if (C.preview) {
                                                    C.preview.removeAttribute('src');
                                                    C.preview.setStyle('display', 'none');
                                                }
                                            },
                                            setup:function (C, D) {
                                                if (C == d) {
                                                    var E = D.data('cke-saved-src') || D.getAttribute('src'),
                                                        F = this;
                                                    this.getDialog().dontResetSize = true;
                                                    F.setValue(E);
                                                    F.setInitValue();
                                                }
                                            },
                                            commit:function (C, D) {
                                                var E = this;
                                                if (C == d && (E.getValue() || E.isChanged())) {
                                                    D.data('cke-saved-src', E.getValue());
                                                    D.setAttribute('src', E.getValue());
                                                } else if (C == g) {
                                                    D.setAttribute('src', '');
                                                    D.removeAttribute('src');
                                                }
                                            },
                                            validate:CKEDITOR.dialog.validate.notEmpty(b.lang.image.urlMissing)
                                        },
                                        {
                                            type:'button',
                                            id:'browse',
                                            style:'display:inline-block;margin-top:10px;',
                                            align:'center',
                                            label:b.lang.common.browseServer,
                                            hidden:true,
                                            filebrowser:'info:txtUrl'
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            id:'txtAlt',
                            type:'text',
                            label:b.lang.image.alt,
                            accessKey:'T',
                            'default':'',
                            onChange:function () {
                                l(this.getDialog());
                            },
                            setup:function (C, D) {
                                if (C == d) this.setValue(D.getAttribute('alt'));
                            },
                            commit:function (C, D) {
                                var E = this;
                                if (C == d) {
                                    if (E.getValue() || E.isChanged()) D.setAttribute('alt', E.getValue());
                                } else if (C == f) D.setAttribute('alt', E.getValue());
                                else if (C == g) D.removeAttribute('alt');
                            }
                        },
                        {
                            id:'txtCaption',
                            type:'text',
                            label:'Caption',
                            onChange:function () {
                                l(this.getDialog());
                            },
                            setup:function (C, D) {
                                if (C == d) {
                                    var I = this.getDialog();
                                    var caption = $(I.cleanImageElement.$).parents('table').find('td:eq(1)').text();
                                    if (caption != null && !($(D.$).hasClass('img_template'))) {
                                        this.setValue(caption.replace('<br>', ''));
                                    }else if($(D.$).hasClass('img_template')){
                                        $('#'+this._.inputId).attr('disabled','disabled');
                                    }
                                    //this.setValue('123')//this la cai form chua caption
                                }
                            },
                            commit:function (C, D) {
                                var E = this;
                                if (C == d) {
                                    //if (E.getValue() || E.isChanged()) D.setAttribute('alt', E.getValue());
                                    //if (E.getValue() || E.isChanged()) D.setAttribute('alt', E.getValue());

                                } else if (C == f) D.setAttribute('alt', E.getValue());
                                else if (C == g) D.removeAttribute('alt');
                            }
                        },
                        {
                            type:'hbox',
                            children:[
                                {
                                    id:'basic',
                                    type:'vbox',
                                    children:[
                                        {
                                            type:'hbox',
                                            widths:['50%', '50%'],
                                            children:[
                                                {
                                                    type:'vbox',
                                                    padding:1,
                                                    children:[
                                                        {
                                                            type:'text',
                                                            width:'40px',
                                                            disabled:'disabled',
                                                            id:'txtWidth',
                                                            label:b.lang.common.width,
                                                            onKeyUp:k,
                                                            onChange:function () {
                                                                o.call(this, 'advanced:txtdlgGenStyle');
                                                            },
                                                            validate:function () {
                                                                var C = this.getValue().match(i),
                                                                    D = !!(C && parseInt(C[1], 10) !== 0);
                                                                if (!D) alert(b.lang.common.invalidWidth);
                                                                return D;
                                                            },
                                                            setup:r,
                                                            commit:function (C, D, E) {
                                                                var F = this.getValue();
                                                                if (C == d) {
                                                                    if (F) D.setStyle('width', CKEDITOR.tools.cssLength(F));
                                                                    else D.removeStyle('width');
                                                                    !E && D.removeAttribute('width');
                                                                } else if (C == f) {
                                                                    var G = F.match(h);
                                                                    if (!G) {
                                                                        var H = this.getDialog().originalElement;
                                                                        if (H.getCustomData('isReady') == 'true') D.setStyle('width', H.$.width + 'px');
                                                                    } else D.setStyle('width', CKEDITOR.tools.cssLength(F));
                                                                } else if (C == g) {
                                                                    D.removeAttribute('width');
                                                                    D.removeStyle('width');
                                                                }
                                                            }
                                                        },
                                                        {
                                                            type:'text',
                                                            id:'txtHeight',
                                                            width:'40px',
                                                            label:b.lang.common.height,
                                                            onKeyUp:k,
                                                            onChange:function () {
                                                                o.call(this, 'advanced:txtdlgGenStyle');
                                                            },
                                                            validate:function () {
                                                                var C = this.getValue().match(i),
                                                                    D = !!(C && parseInt(C[1], 10) !== 0);
                                                                if (!D) alert(b.lang.common.invalidHeight);
                                                                return D;
                                                            },
                                                            setup:r,
                                                            commit:function (C, D, E) {
                                                                var F = this.getValue();
                                                                if (C == d) {
                                                                    if (F) D.setStyle('height', CKEDITOR.tools.cssLength(F));
                                                                    else D.removeStyle('height');
                                                                    !E && D.removeAttribute('height');
                                                                } else if (C == f) {
                                                                    var G = F.match(h);
                                                                    if (!G) {
                                                                        var H = this.getDialog().originalElement;
                                                                        if (H.getCustomData('isReady') == 'true') D.setStyle('height', H.$.height + 'px');
                                                                    } else D.setStyle('height', CKEDITOR.tools.cssLength(F));
                                                                } else if (C == g) {
                                                                    D.removeAttribute('height');
                                                                    D.removeStyle('height');
                                                                }
                                                            }
                                                        },
                                                        {
                                                            type:'text',
                                                            width:'40px',
                                                            id:'txtWidthTrue',
                                                            label:'True width',
                                                            onLoad:function(){

                                                            },
                                                            setup:function (type, element) {
                                                                var data_natural_width = element.getAttribute('data-natural-width'),
                                                                    $this = this,
                                                                    dialog = this.getDialog();
                                                                $this.setValue(data_natural_width);
                                                            }

                                                        }
                                                    ]
                                                },
                                                {
                                                    id:'ratioLock',
                                                    type:'html',
                                                    style:'margin-top:30px;width:40px;height:40px;',
                                                    onLoad:function () {
                                                        var C = CKEDITOR.document.getById(x),
                                                            D = CKEDITOR.document.getById(w);
                                                        if (C) {
                                                            C.on('click', function (E) {
                                                                q(this);
                                                                E.data && E.data.preventDefault();
                                                            }, this.getDialog());
                                                            C.on('mouseover', function () {
                                                                this.addClass('cke_btn_over');
                                                            }, C);
                                                            C.on('mouseout', function () {
                                                                this.removeClass('cke_btn_over');
                                                            }, C);
                                                        }
                                                        if (D) {
                                                            D.on('click', function (E) {
                                                                var J = this;
                                                                var F = p(J),
                                                                    G = J.originalElement,
                                                                    H = J.getValueOf('info', 'txtWidth');
                                                                if (G.getCustomData('isReady') == 'true' && H) {
                                                                    var I = G.$.height / G.$.width * H;
                                                                    if (!isNaN(I)) {
                                                                        J.setValueOf('info', 'txtHeight', Math.round(I));
                                                                        l(J);
                                                                    }
                                                                }
                                                                E.data && E.data.preventDefault();
                                                            }, this.getDialog());
                                                            D.on('mouseover', function () {
                                                                this.addClass('cke_btn_over');
                                                            }, D);
                                                            D.on('mouseout', function () {
                                                                this.removeClass('cke_btn_over');
                                                            }, D);
                                                        }
                                                    },
                                                    html:'<div><a href="javascript:void(0)" tabindex="-1" title="' + b.lang.image.lockRatio + '" class="cke_btn_locked" id="' + w + '" role="checkbox"><span class="cke_icon"></span><span class="cke_label">' + b.lang.image.lockRatio + '</span></a>' + '<a href="javascript:void(0)" tabindex="-1" title="' + b.lang.image.resetSize + '" class="cke_btn_reset" id="' + x + '" role="button"><span class="cke_label">' + b.lang.image.resetSize + '</span></a>' + '</div>'
                                                }
                                            ]
                                        },
                                        {
                                            type:'vbox',
                                            padding:1,
                                            children:[
                                                {
                                                    type:'text',
                                                    id:'txtBorder',
                                                    width:'60px',
                                                    label:b.lang.image.border,
                                                    'default':'',
                                                    onKeyUp:function () {
                                                        l(this.getDialog());
                                                    },
                                                    onChange:function () {
                                                        o.call(this, 'advanced:txtdlgGenStyle');
                                                    },
                                                    validate:CKEDITOR.dialog.validate.integer(b.lang.image.validateBorder),
                                                    setup:function (C, D) {
                                                        if (C == d) {
                                                            var E, F = D.getStyle('border-width');
                                                            F = F && F.match(/^(\d+px)(?: \1 \1 \1)?$/);
                                                            E = F && parseInt(F[1], 10);
                                                            isNaN(parseInt(E, 10)) && (E = D.getAttribute('border'));
                                                            this.setValue(E);
                                                        }
                                                    },
                                                    commit:function (C, D, E) {
                                                        var F = parseInt(this.getValue(), 10);
                                                        if (C == d || C == f) {
                                                            if (!isNaN(F)) {
                                                                D.setStyle('border-width', CKEDITOR.tools.cssLength(F));
                                                                D.setStyle('border-style', 'solid');
                                                            } else if (!F && this.isChanged()) {
                                                                D.removeStyle('border-width');
                                                                D.removeStyle('border-style');
                                                                D.removeStyle('border-color');
                                                            }
                                                            if (!E && C == d) D.removeAttribute('border');
                                                        } else if (C == g) {
                                                            D.removeAttribute('border');
                                                            D.removeStyle('border-width');
                                                            D.removeStyle('border-style');
                                                            D.removeStyle('border-color');
                                                        }
                                                    }
                                                }/*,
                                                {
                                                    type:'text',
                                                    id:'txtHSpace',
                                                    width:'60px',
                                                    label:b.lang.image.hSpace,
                                                    'default':'',
                                                    onKeyUp:function () {
                                                        l(this.getDialog());
                                                    },
                                                    onChange:function () {
                                                        o.call(this, 'advanced:txtdlgGenStyle');
                                                    },
                                                    validate:CKEDITOR.dialog.validate.integer(b.lang.image.validateHSpace),
                                                    setup:function (C, D) {
                                                        if (C == d) {
                                                            var E, F, G, H = D.getStyle('margin-left'),
                                                                I = D.getStyle('margin-right');
                                                            H = H && H.match(j);
                                                            I = I && I.match(j);
                                                            F = parseInt(H, 10);
                                                            G = parseInt(I, 10);
                                                            E = F == G && F;
                                                            isNaN(parseInt(E, 10)) && (E = D.getAttribute('hspace'));
                                                            this.setValue(E);
                                                        }
                                                    },
                                                    commit:function (C, D, E) {
                                                        var F = parseInt(this.getValue(), 10);
                                                        if (C == d || C == f) {
                                                            if (!isNaN(F)) {
                                                                D.setStyle('margin-left', CKEDITOR.tools.cssLength(F));
                                                                D.setStyle('margin-right', CKEDITOR.tools.cssLength(F));
                                                            } else if (!F && this.isChanged()) {
                                                                D.removeStyle('margin-left');
                                                                D.removeStyle('margin-right');
                                                            }
                                                            if (!E && C == d) D.removeAttribute('hspace');
                                                        } else if (C == g) {
                                                            D.removeAttribute('hspace');
                                                            D.removeStyle('margin-left');
                                                            D.removeStyle('margin-right');
                                                        }
                                                    }
                                                },
                                                {
                                                    type:'text',
                                                    id:'txtVSpace',
                                                    width:'60px',
                                                    label:b.lang.image.vSpace,
                                                    'default':'',
                                                    onKeyUp:function () {
                                                        l(this.getDialog());
                                                    },
                                                    onChange:function () {
                                                        o.call(this, 'advanced:txtdlgGenStyle');
                                                    },
                                                    validate:CKEDITOR.dialog.validate.integer(b.lang.image.validateVSpace),
                                                    setup:function (C, D) {
                                                        if (C == d) {
                                                            var E, F, G, H = D.getStyle('margin-top'),
                                                                I = D.getStyle('margin-bottom');
                                                            H = H && H.match(j);
                                                            I = I && I.match(j);
                                                            F = parseInt(H, 10);
                                                            G = parseInt(I, 10);
                                                            E = F == G && F;
                                                            isNaN(parseInt(E, 10)) && (E = D.getAttribute('vspace'));
                                                            this.setValue(E);
                                                        }
                                                    },
                                                    commit:function (C, D, E) {
                                                        var F = parseInt(this.getValue(), 10);
                                                        if (C == d || C == f) {
                                                            if (!isNaN(F)) {
                                                                D.setStyle('margin-top', CKEDITOR.tools.cssLength(F));
                                                                D.setStyle('margin-bottom', CKEDITOR.tools.cssLength(F));
                                                            } else if (!F && this.isChanged()) {
                                                                D.removeStyle('margin-top');
                                                                D.removeStyle('margin-bottom');
                                                            }
                                                            if (!E && C == d) D.removeAttribute('vspace');
                                                        } else if (C == g) {
                                                            D.removeAttribute('vspace');
                                                            D.removeStyle('margin-top');
                                                            D.removeStyle('margin-bottom');
                                                        }
                                                    }
                                                }*/,
                                                {
                                                    id:'cmbAlign',
                                                    type:'select',
                                                    widths:['35%', '65%'],
                                                    style:'width:90px',
                                                    label:b.lang.common.align,
                                                    'default':'',
                                                    items:[
                                                        [b.lang.common.notSet, ''],
                                                        [b.lang.common.alignLeft, 'left'],
                                                        [b.lang.common.alignRight, 'right']
                                                    ],
                                                    onChange:function () {
                                                        l(this.getDialog());
                                                        o.call(this, 'advanced:txtdlgGenStyle');
                                                    },
                                                    setup:function (C, D) {
                                                        if (C == d) {
                                                            var E = D.getStyle('float');
                                                            switch (E) {
                                                                case 'inherit':
                                                                case 'none':
                                                                    E = '';
                                                            }
                                                            !E && (E = (D.getAttribute('align') || '').toLowerCase());
                                                            this.setValue(E);
                                                        }
                                                    },
                                                    commit:function (C, D, E) {
                                                        var F = this.getValue();
                                                        if (C == d || C == f) {
                                                            if (F) D.setStyle('float', F);
                                                            else D.removeStyle('float');
                                                            if (!E && C == d) {
                                                                F = (D.getAttribute('align') || '').toLowerCase();
                                                                switch (F) {
                                                                    case 'left':
                                                                    case 'right':
                                                                        D.removeAttribute('align');
                                                                }
                                                            }
                                                        } else if (C == g) D.removeStyle('float');
                                                    }
                                                }
                                            ]
                                        }
                                    ]
                                },
                                {
                                    type:'vbox',
                                    height:'250px',
                                    children:[
                                        {
                                            type:'html',
                                            id:'htmlPreview',
                                            style:'width:95%;',
                                            html:'<div>' + CKEDITOR.tools.htmlEncode(b.lang.common.preview) + '<br>' + '<div id="' + y + '" class="ImagePreviewLoader" style="display:none"><div class="loading">&nbsp;</div></div>' + '<div id="' + z + '" class="ImagePreviewBox"><table><tr><td>' + '<a href="javascript:void(0)" target="_blank" onclick="return false;" id="' + A + '">' + '<img id="' + B + '" alt="" /></a>' + (b.config.image_previewText || 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim. Sed tortor. Curabitur molestie. Duis velit augue, condimentum at, ultrices a, luctus ut, orci. Donec pellentesque egestas eros. Integer cursus, augue in cursus faucibus, eros pede bibendum sem, in tempus tellus justo quis ligula. Etiam eget tortor. Vestibulum rutrum, est ut placerat elementum, lectus nisl aliquam velit, tempor aliquam eros nunc nonummy metus. In eros metus, gravida a, gravida sed, lobortis id, turpis. Ut ultrices, ipsum at venenatis fringilla, sem nulla lacinia tellus, eget aliquet turpis mauris non enim. Nam turpis. Suspendisse lacinia. Curabitur ac tortor ut ipsum egestas elementum. Nunc imperdiet gravida mauris.') + '</td></tr></table></div></div>'
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            id : 'attr_img',
                            type : 'checkbox',
                            label : 'Zoom photo',
                            style : 'margin-top:10px;margin-bottom:10px;',
                            onChange : function(){
                                l(this.getDialog());
                            },
                            setup:function (type, element) {
                                var data_zoom = element.getAttribute('data-zoom'),
                                    $this = this,
                                    dialog = this.getDialog();
                                $this.setValue(data_zoom);
                            }
                        },
                        {
                            id : 'attr_price',
                            type : 'text',
                            label : 'Photo Price',
                            style: 'width:200px;',
                            onChange : function(){
                                l(this.getDialog());
                            },
                            setup:function (type, element) {
                                var data_price = element.getAttribute('data-component-price'),
                                    $this = this,
                                    dialog = this.getDialog();
                                $this.setValue(data_price);
                            }
                        }
                    ]
                },
                {
                    id:'Link',
                    label:b.lang.link.title,
                    padding:0,
                    elements:[
                        {
                            id:'txtUrl',
                            type:'text',
                            label:b.lang.common.url,
                            style:'width: 100%',
                            'default':'',
                            setup:function (C, D) {
                                if (C == e) {
                                    var E = D.data('cke-saved-href');
                                    if (!E) E = D.getAttribute('href');
                                    this.setValue(E);
                                }
                            },
                            commit:function (C, D) {
                                var F = this;
                                if (C == e) if (F.getValue() || F.isChanged()) {
                                    var E = decodeURI(F.getValue());
                                    D.data('cke-saved-href', E);
                                    D.setAttribute('href', E);
                                    if (F.getValue() || !b.config.image_removeLinkByEmptyURL) F.getDialog().addLink = true;
                                }
                            }
                        },
                        {
                            type:'button',
                            id:'browse',
                            filebrowser:{
                                action:'Browse',
                                target:'Link:txtUrl',
                                url:b.config.filebrowserImageBrowseLinkUrl
                            },
                            style:'float:right',
                            hidden:true,
                            label:b.lang.common.browseServer
                        },
                        {
                            id:'cmbTarget',
                            type:'select',
                            label:b.lang.common.target,
                            'default':'',
                            items:[
                                [b.lang.common.notSet, ''],
                                [b.lang.common.targetNew, '_blank'],
                                [b.lang.common.targetTop, '_top'],
                                [b.lang.common.targetSelf, '_self'],
                                [b.lang.common.targetParent, '_parent']
                            ],
                            setup:function (C, D) {
                                if (C == e) this.setValue(D.getAttribute('target') || '');
                            },
                            commit:function (C, D) {
                                if (C == e) if (this.getValue() || this.isChanged()) D.setAttribute('target', this.getValue());
                            }
                        }
                    ]
                },
                /*{id:'Upload',hidden:true,filebrowser:'uploadButton',label:b.lang.image.upload,elements:[{type:'file',id:'upload',label:b.lang.image.btnUpload,style:'height:40px',size:38},{type:'fileButton',id:'uploadButton',filebrowser:'info:txtUrl',label:b.lang.image.btnUpload,'for':['Upload','upload']}]},*/ {
                    id:'advanced',
                    label:b.lang.common.advancedTab,
                    elements:[
                        {
                            type:'hbox',
                            widths:['50%', '25%', '25%'],
                            children:[
                                {
                                    type:'text',
                                    id:'linkId',
                                    label:b.lang.common.id,
                                    setup:function (C, D) {
                                        if (C == d) this.setValue(D.getAttribute('id'));
                                    },
                                    commit:function (C, D) {
                                        if (C == d) if (this.getValue() || this.isChanged()) D.setAttribute('id', this.getValue());
                                    }
                                },
                                {
                                    id:'cmbLangDir',
                                    type:'select',
                                    style:'width : 100px;',
                                    label:b.lang.common.langDir,
                                    'default':'',
                                    items:[
                                        [b.lang.common.notSet, ''],
                                        [b.lang.common.langDirLtr, 'ltr'],
                                        [b.lang.common.langDirRtl, 'rtl']
                                    ],
                                    setup:function (C, D) {
                                        if (C == d) this.setValue(D.getAttribute('dir'));
                                    },
                                    commit:function (C, D) {
                                        if (C == d) if (this.getValue() || this.isChanged()) D.setAttribute('dir', this.getValue());
                                    }
                                },
                                {
                                    type:'text',
                                    id:'txtLangCode',
                                    label:b.lang.common.langCode,
                                    'default':'',
                                    setup:function (C, D) {
                                        if (C == d) this.setValue(D.getAttribute('lang'));
                                    },
                                    commit:function (C, D) {
                                        if (C == d) if (this.getValue() || this.isChanged()) D.setAttribute('lang', this.getValue());
                                    }
                                }
                            ]
                        },
                        {
                            type:'text',
                            id:'txtGenLongDescr',
                            label:b.lang.common.longDescr,
                            setup:function (C, D) {
                                if (C == d) this.setValue(D.getAttribute('longDesc'));
                            },
                            commit:function (C, D) {
                                if (C == d) if (this.getValue() || this.isChanged()) D.setAttribute('longDesc', this.getValue());
                            }
                        },
                        {
                            type:'hbox',
                            widths:['50%', '50%'],
                            children:[
                                {
                                    type:'text',
                                    id:'txtGenClass',
                                    label:b.lang.common.cssClass,
                                    'default':'',
                                    setup:function (C, D) {
                                        if (C == d) this.setValue(D.getAttribute('class'));
                                    },
                                    commit:function (C, D) {
                                        if (C == d) if (this.getValue() || this.isChanged()) D.setAttribute('class', this.getValue());
                                    }
                                },
                                {
                                    type:'text',
                                    id:'txtGenTitle',
                                    label:b.lang.common.advisoryTitle,
                                    'default':'',
                                    onChange:function () {
                                        l(this.getDialog());
                                    },
                                    setup:function (C, D) {
                                        if (C == d) this.setValue(D.getAttribute('title'));
                                    },
                                    commit:function (C, D) {
                                        var E = this;
                                        if (C == d) {
                                            if (E.getValue() || E.isChanged()) D.setAttribute('title', E.getValue());
                                        } else if (C == f) D.setAttribute('title', E.getValue());
                                        else if (C == g) D.removeAttribute('title');
                                    }
                                }
                            ]
                        },
                        {
                            type:'text',
                            id:'txtdlgGenStyle',
                            label:b.lang.common.cssStyle,
                            validate:CKEDITOR.dialog.validate.inlineStyle(b.lang.common.invalidInlineStyle),
                            'default':'',
                            setup:function (C, D) {
                                if (C == d) {
                                    var E = D.getAttribute('style');
                                    if (!E && D.$.style.cssText) E = D.$.style.cssText;
                                    this.setValue(E);
                                    var F = D.$.style.height,
                                        G = D.$.style.width,
                                        H = (F ? F : '').match(h),
                                        I = (G ? G : '').match(h);
                                    this.attributesInStyle = {
                                        height:!!H,
                                        width:!!I
                                    };
                                }
                            },
                            onChange:function () {
                                o.call(this, ['info:cmbFloat', 'info:cmbAlign', 'info:txtVSpace', 'info:txtHSpace', 'info:txtBorder', 'info:txtWidth', 'info:txtHeight']);
                                l(this);
                            },
                            commit:function (C, D) {
                                if (C == d && (this.getValue() || this.isChanged())) D.setAttribute('style', this.getValue());
                            }
                        }
                    ]
                }
            ]
        };
    };
    CKEDITOR.dialog.add('image', function (b) {
        return a(b, 'image');
    });
    CKEDITOR.dialog.add('imagebutton', function (b) {
        return a(b, 'imagebutton');
    });
})();