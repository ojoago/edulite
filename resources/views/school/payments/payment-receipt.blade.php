<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{env('APP_NAME',APP_NAME)}} - {{$invoiceDetails->fullname}} Payment Receipt</title>
    <meta content="description" name="Upgrade your school with edulite suite">
    <meta content="keywords" name="education, edulite, education suite, educate, education is light, secondary school, school, primary school, nursery school">
    <meta content="author" name="edulite">

    <!-- Favicons -->
    <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="icon">
    <link href="{{asset('files/edulite/edulite drk bg.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('themes/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="{{asset('themes/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('themes/css/custom/style.css')}}" rel="stylesheet">

    <script src="{{asset('js/jquery.3.7.0.min.js')}}"></script>
    <script src="{{asset('printThis/printThis.js')}}"></script>
    <style>
        body {
            margin: 20px 160px;
        }

        .flex-container,
        .flex-row {
            display: flex;
            justify-content: space-between;
        }

        .text-content {
            flex-basis: 60%;
            text-align: center;
        }

        .text-content>.h4,
        .text-content>.h3 {
            margin-bottom: 1px;
        }

        .text-content>p {
            margin: 1px;
            font-size: small;
        }

        .logo-image {
            width: 100px !important;
            border-radius: 15px;
        }

        .logo-image>img {
            width: 100%;
        }

        .flex-row {
            /* height: 200px; */
            justify-content: space-between;
        }
    </style>

</head>

<body>
    <!-- <link href="{{asset('printThis/css/normalize.css')}}" rel="stylesheet">
<link href="{{asset('printThis/css/skeleton.css')}}" rel="stylesheet"> -->

    @if(!empty($invoiceDetails))
    <div class="container-fluid">
        <div class="flex-row">
            <div class="img-left logo-image">
                @php $imgUrl = asset("/files/logo/".$invoiceDetails->school_logo) @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive">
            </div>
            <div class="text-content">
                <h3 class="text-success h4">{{strtoupper(getSchoolName())}}</h3>
                <small>{{$invoiceDetails->school_moto}}</small>
                <p>{{$invoiceDetails->school_address}}</p>
                <span>{{$invoiceDetails->school_contact}}</span>
                <p>{{$invoiceDetails->school_email}}</p>
            </div>
            <div class="img-left logo-image">
                <div class="personal-detail">
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td colspan="2" class="text-center">
                                {{$invoiceDetails->fullname}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                {{$invoiceDetails->reg_number}}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                {{$invoiceDetails->invoice_number}}
                            </td>
                            <td class="text-center">
                                {{matchInvoiceStatus($invoiceDetails->status)}}
                            </td>
                        </tr>

                    </table>
                </div>

            </div>
            <div class="img-left logo-image">
                <div class="personal-detail">
                    <table class="table table-hover table-striped table-bordered">
                        <tr>
                            <td colspan="2" class="text-center">
                                Payment Invoice
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                {{$invoiceDetails->term}}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                {{$invoiceDetails->session}}
                            </td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
        <div class="table table-responsive">
            <div class="flex-container">
                <table class="table table-hover table-striped table-bordered examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            <th width="5%">S/N</th>
                            <th class="flat-row p-2">Item</th>
                            <th class="flat-row">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->fee_name}}</td>
                            <td>{{number_format($row->amount,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Total</td>
                            <td>{{number_format($invoiceDetails->total,2)}}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-3">
        <button class="btn btn-success" id="printReceipt"> <i class="bi bi-printer"></i> </button>
        <a href="{{route('payment.records')}}">
            <button class="btn btn-success"> <i class="bi bi-link"></i> </button>
        </a>
    </div>

    @else
    <div class="container text-center text-uppercase">
        <h1 class="text-danger text-center"> Wrong Invoice Selected</h1>
        <div class="col-3">
            <a href="{{route('payment.records')}}">
                <button class="btn btn-success"> <i class="bi bi-link"></i> </button>
            </a>
        </div>
    </div>
    @endif

    <script>
        $(document).ready(function() {
            $('#printReceipt').click(function() {
                $('.container-fluid').printThis({
                    importCSS: true,
                });
            })
            /*
             * printThis v1.12.2
             * @desc Printing plug-in for jQuery
             * @author Jason Day
             *
             * Resources (based on) :
             *              jPrintArea: http://plugins.jquery.com/project/jPrintArea
             *              jqPrint: https://github.com/permanenttourist/jquery.jqprint
             *              Ben Nadal: http://www.bennadel.com/blog/1591-Ask-Ben-Print-Part-Of-A-Web-Page-With-jQuery.htm
             *
             * Licensed under the MIT licence:
             *              http://www.opensource.org/licenses/mit-license.php
             *
             * (c) Jason Day 2015
             *
             * Usage:
             *
             *  $("#mySelector").printThis({
             *      debug: false,               // show the iframe for debugging
             *      importCSS: true,            // import page CSS
             *      importStyle: false,         // import style tags
             *      printContainer: true,       // grab outer container as well as the contents of the selector
             *      loadCSS: "path/to/my.css",  // path to additional css file - us an array [] for multiple
             *      pageTitle: "",              // add title to print page
             *      removeInline: false,        // remove all inline styles from print elements
             *      printDelay: 333,            // variable print delay
             *      header: null,               // prefix to html
             *      footer: null,               // postfix to html
             *      base: false,                // preserve the BASE tag, or accept a string for the URL
             *      formValues: true,           // preserve input/form values
             *      canvas: false,              // copy canvas elements (experimental)
             *      doctypeString: '...',       // enter a different doctype for older markup
             *      removeScripts: false,       // remove script tags from print content
             *      copyTagClasses: false       // copy classes from the html & body tag
             *  });
             *
             * Notes:
             *  - the loadCSS will load additional css (with or without @media print) into the iframe, adjusting layout
             */
            ;
            (function($) {

                function appendContent($el, content) {
                    if (!content) return;

                    // Simple test for a jQuery element
                    $el.append(content.jquery ? content.clone() : content);
                }

                function appendBody($body, $element, opt) {
                    // Clone for safety and convenience
                    // Calls clone(withDataAndEvents = true) to copy form values.
                    var $content = $element.clone(opt.formValues);

                    if (opt.formValues) {
                        // Copy original select and textarea values to their cloned counterpart
                        // Makes up for inability to clone select and textarea values with clone(true)
                        copyValues($element, $content, 'select, textarea');
                    }

                    if (opt.removeScripts) {
                        $content.find('script').remove();
                    }

                    if (opt.printContainer) {
                        // grab $.selector as container
                        $content.appendTo($body);
                    } else {
                        // otherwise just print interior elements of container
                        $content.each(function() {
                            $(this).children().appendTo($body)
                        });
                    }
                }

                // Copies values from origin to clone for passed in elementSelector
                function copyValues(origin, clone, elementSelector) {
                    var $originalElements = origin.find(elementSelector);

                    clone.find(elementSelector).each(function(index, item) {
                        $(item).val($originalElements.eq(index).val());
                    });
                }

                var opt;
                $.fn.printThis = function(options) {
                    opt = $.extend({}, $.fn.printThis.defaults, options);
                    var $element = this instanceof jQuery ? this : $(this);

                    var strFrameName = "printThis-" + (new Date()).getTime();

                    if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
                        // Ugly IE hacks due to IE not inheriting document.domain from parent
                        // checks if document.domain is set by comparing the host name against document.domain
                        var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</s" + "cript></head><body></body>\")";
                        var printI = document.createElement('iframe');
                        printI.name = "printIframe";
                        printI.id = strFrameName;
                        printI.className = "MSIE";
                        document.body.appendChild(printI);
                        printI.src = iframeSrc;

                    } else {
                        // other browsers inherit document.domain, and IE works if document.domain is not explicitly set
                        var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
                        $frame.appendTo("body");
                    }

                    var $iframe = $("#" + strFrameName);

                    // show frame if in debug mode
                    if (!opt.debug) $iframe.css({
                        position: "absolute",
                        width: "0px",
                        height: "0px",
                        left: "-600px",
                        top: "-600px"
                    });

                    // $iframe.ready() and $iframe.load were inconsistent between browsers
                    setTimeout(function() {

                        // Add doctype to fix the style difference between printing and render
                        function setDocType($iframe, doctype) {
                            var win, doc;
                            win = $iframe.get(0);
                            win = win.contentWindow || win.contentDocument || win;
                            doc = win.document || win.contentDocument || win;
                            doc.open();
                            doc.write(doctype);
                            doc.close();
                        }

                        if (opt.doctypeString) {
                            setDocType($iframe, opt.doctypeString);
                        }

                        var $doc = $iframe.contents(),
                            $head = $doc.find("head"),
                            $body = $doc.find("body"),
                            $base = $('base'),
                            baseURL;

                        // add base tag to ensure elements use the parent domain
                        if (opt.base === true && $base.length > 0) {
                            // take the base tag from the original page
                            baseURL = $base.attr('href');
                        } else if (typeof opt.base === 'string') {
                            // An exact base string is provided
                            baseURL = opt.base;
                        } else {
                            // Use the page URL as the base
                            baseURL = document.location.protocol + '//' + document.location.host;
                        }

                        $head.append('<base href="' + baseURL + '">');

                        // import page stylesheets
                        if (opt.importCSS) $("link[rel=stylesheet]").each(function() {
                            var href = $(this).attr("href");
                            if (href) {
                                var media = $(this).attr("media") || "all";
                                $head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>");
                            }
                        });

                        // import style tags
                        if (opt.importStyle) $("style").each(function() {
                            $head.append(this.outerHTML);
                        });

                        // add title of the page
                        if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");

                        // import additional stylesheet(s)
                        if (opt.loadCSS) {
                            if ($.isArray(opt.loadCSS)) {
                                jQuery.each(opt.loadCSS, function(index, value) {
                                    $head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
                                });
                            } else {
                                $head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
                            }
                        }

                        // copy 'root' tag classes
                        var tag = opt.copyTagClasses;
                        if (tag) {
                            tag = tag === true ? 'bh' : tag;
                            if (tag.indexOf('b') !== -1) {
                                $body.addClass($('body')[0].className);
                            }
                            if (tag.indexOf('h') !== -1) {
                                $doc.find('html').addClass($('html')[0].className);
                            }
                        }

                        // print header
                        appendContent($body, opt.header);

                        if (opt.canvas) {
                            // add canvas data-ids for easy access after cloning.
                            var canvasId = 0;
                            // .addBack('canvas') adds the top-level element if it is a canvas.
                            $element.find('canvas').addBack('canvas').each(function() {
                                $(this).attr('data-printthis', canvasId++);
                            });
                        }

                        appendBody($body, $element, opt);

                        if (opt.canvas) {
                            // Re-draw new canvases by referencing the originals
                            $body.find('canvas').each(function() {
                                var cid = $(this).data('printthis'),
                                    $src = $('[data-printthis="' + cid + '"]');

                                this.getContext('2d').drawImage($src[0], 0, 0);

                                // Remove the markup from the original
                                $src.removeData('printthis');
                            });
                        }

                        // remove inline styles
                        if (opt.removeInline) {
                            // $.removeAttr available jQuery 1.7+
                            if ($.isFunction($.removeAttr)) {
                                $doc.find("body *").removeAttr("style");
                            } else {
                                $doc.find("body *").attr("style", "");
                            }
                        }

                        // print "footer"
                        appendContent($body, opt.footer);

                        setTimeout(function() {
                            if ($iframe.hasClass("MSIE")) {
                                // check if the iframe was created with the ugly hack
                                // and perform another ugly hack out of neccessity
                                window.frames["printIframe"].focus();
                                $head.append("<script>  window.print(); </s" + "cript>");
                            } else {
                                // proper method
                                if (document.queryCommandSupported("print")) {
                                    $iframe[0].contentWindow.document.execCommand("print", false, null);
                                } else {
                                    $iframe[0].contentWindow.focus();
                                    $iframe[0].contentWindow.print();
                                }
                            }

                            // remove iframe after print
                            if (!opt.debug) {
                                setTimeout(function() {
                                    $iframe.remove();
                                }, 1000);
                            }

                        }, opt.printDelay);

                    }, 333);

                };

                // defaults
                $.fn.printThis.defaults = {
                    debug: false, // show the iframe for debugging
                    importCSS: true, // import parent page css
                    importStyle: false, // import style tags
                    printContainer: true, // print outer container/$.selector
                    loadCSS: "", // load an additional css file - load multiple stylesheets with an array []
                    pageTitle: "", // add title to print page
                    removeInline: false, // remove all inline styles
                    printDelay: 333, // variable print delay
                    header: null, // prefix to html
                    footer: null, // postfix to html
                    formValues: true, // preserve input/form values
                    canvas: false, // copy canvas content (experimental)
                    base: false, // preserve the BASE tag, or accept a string for the URL
                    doctypeString: '<!DOCTYPE html>', // html doctype
                    removeScripts: false, // remove script tags before appending
                    copyTagClasses: false // copy classes from the html & body tag
                };
            })(jQuery);


        })
    </script>