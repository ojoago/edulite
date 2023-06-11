<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{env('APP_NAME',APP_NAME)}} - {{$std->fullname}} Report card</title>
    <meta content="description" name="Upgrade your school with edulite suite, 
                                    and ease the stress of school manual process at less cost.
                                     get accurate and accessible information about students, staff remotely.
                                      Allow guardian/parent keep track of their childrens performance easily 
                                      and at you their own time and convenience. EduLite manage school process 
                                      such as report card, performance charts, attendance, student promotion, 
                                      automated principal comment, hostel/portals, student pick up rider, 
                                      event notification such as holidays, notify parent student exam timetable">
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

        .personal-detail,
        .flex-col {
            flex-basis: 40%;
            margin: 3px;
            /* justify-content: space-between; */
        }

        .student-img {
            flex-basis: 15%;
            border-radius: 5px;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
            max-height: 200px;
        }

        .student-img>img {
            width: 100%;
            height: 100%;
        }

        .signature-base {
            width: 60px !important;
            align-items: center;
            justify-content: center;
        }

        .signature-base>img {
            width: 100%;
        }


        table {
            /* background: #fff; */
            /* box-shadow: 0 0 0 10px #fff; */

            /* width: calc(100% - 20px); */
            border-spacing: 5px;
        }

        tr>th,
        tr>td {
            padding: 5px !important;
        }

        .flat-row {
            padding: 3px !important;
            width: auto !important;
            /* padding-right: 0 !important; */
        }

        .rotate-up {
            vertical-align: bottom;
            text-align: center;
            /* font-weight: normal; */
        }

        .rotate-up {
            -ms-writing-mode: tb-rl;
            -webkit-writing-mode: vertical-rl;
            writing-mode: vertical-rl;
            /* translate(25px, 51px) // 45 is really 360-45 */
            /* rotate(315deg); */
            /* transform: rotate(315deg) translate(25px, 51px); */
            white-space: nowrap;
            /* overflow: hidden; */
            /* width: 25px; */
            transform: rotate(180deg);
            /* height: 150px; */
            width: 30px;
            /* transform-origin: left bottom; */
            /* box-sizing: border-box; */
        }

        @media screen and (max-width:560px) {
            .student-img {
                border: none !important;
                display: none !important;
            }

            .flex-container {
                flex-direction: column !important;
            }

            .examTable{
               width: 100% !important;
            }

            body {
                margin: 1px;
            }
        }

        @media print {
            .header,
            #header,
            button {
                display: none !important;
            }

            .rotate-up {
                vertical-align: bottom !important;
                height: 120px;
                text-align: center !important;
            }

            .rotate-up {
                -ms-writing-mode: tb-rl !important;
                -webkit-writing-mode: vertical-rl !important;
                writing-mode: vertical-rl !important;
                white-space: nowrap !important;
                transform: rotate(90deg) !important;
                width: 30px !important;
                transform: translate(45px, -20px)
            }

            .student-img {
                border: none;
            }

            #column_Chart {
                width: auto;
            }
        }
    </style>

</head>

<body>
    <!-- <link href="{{asset('printThis/css/normalize.css')}}" rel="stylesheet">
<link href="{{asset('printThis/css/skeleton.css')}}" rel="stylesheet"> -->

    <div class="container-fluid">
        @include('school.student.result.headers.top')
        <hr>
        <div class="flex-row">
            <div class="personal-detail">
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" class="text-center" style="padding: 20px!important;">
                            {{@$std->fullname}}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center text-uppercase" style="padding: 10px!important;">
                            personal Data
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Gender
                        </td>
                        <td>
                            {{matchGender($std->gender)}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Admin No.
                        </td>
                        <td>
                            {{$std->reg_number}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            D.O.B
                        </td>
                        <td>
                            {{$std->dob}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            AGE
                        </td>
                        <td>
                            {{dateToAge($std->dob)}}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="flex-col">
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" align="center">
                            Class Data
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Class
                        </td>
                        <td>
                            {{$results->arm}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Term
                        </td>
                        <td>
                            {{$results->term}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Session
                        </td>
                        <td>
                            {{$results->session}}
                        </td>
                    </tr>
                </table>
                <table class="table table-hover table-striped table-bordered">
                    <tr>
                        <td colspan="2" align="center">
                            Class Attendance
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            Number of Times Open
                        </td>
                        <td>
                            {{date_diff_weekdays($results->begin,$results->end)}}
                        </td>
                    </tr>
                    <tr>
                        @if($results->present>0 || $results->absent>0)
                        <td>
                            Present: {{$results->present}}
                        </td>
                        <td>
                            Absent: {{$results->absent}}
                        </td>
                        @else
                        <td colspan="2" align="center">
                            No Attendance Record
                        </td>

                        @endif
                    </tr>

                </table>
            </div>
            <div class="img img-responsive student-img">
                @php $imgUrl = $std->passport ? asset("/files/images/".$std->passport) :'' @endphp
                <img src="{{$imgUrl}}" alt="" class="img img-responsive" id="student-img">
            </div>
        </div>
        <div class="table table-responsive">
            <div class="flex-container">
                <table class="table table-hover table-striped table-bordered examTable" cellpadding="pixels">
                    <thead>
                        <tr>
                            <th colspan="2"></th>

                            @foreach($scoreSettings as $row)
                            <th class="rotate-up">{{$row->title}}</th>
                            @endforeach
                            <th class="rotate-up">TOTAL</th>
                            <th class="rotate-up">CLASS MIN</th>
                            <th class="rotate-up">CLASS AVG</th>
                            <th class="rotate-up">CLASS MAX</th>
                            <th class="rotate-up">GRADE</th>
                            <th class="rotate-up">SUBJECT POSITION</th>
                        </tr>
                        <tr>
                            <th width="5%">S/N</th>
                            <th class="flat-row p-2">SUBJECTS</th>
                            @foreach($scoreSettings as $row)
                            <th class="flat-row">{{$row->score}}</th>
                            @endforeach
                            <th class="flat-row">100</th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row"></th>
                            <th class="flat-row">TEACHER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $columnChart = [['Subject','Student Score','Class Min','Class AVG','Class Max']] @endphp
                        @foreach($subResult as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->subject}}</td>
                            @foreach($scoreSettings as $hrow)
                            <td>
                                {{ number_format(getTitleAVGScore(student:$std->pid,pid:$hrow->assessment_title_pid,param:$param,sub:$row->type),1)}}
                            </td>
                            @endforeach
                            <td>{{number_format($row->total,1)}}</td>
                            <td>{{number_format($row->min,1)}}</td>
                            <td>{{number_format($row->avg,1)}}</td>
                            <td>{{number_format($row->max,1)}}</td>
                            @php array_push($columnChart,[$row->subject,$row->total,$row->min,$row->avg,$row->max]) @endphp
                            <td>{{rtnGrade($row->total,$grades)}}</td>
                            <td>{{ordinalFormat($row->position)}}</td>
                            <td>{{$row->subject_teacher}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                        </tr>
                    </tfoot>
                </table>
                <div class="flex-col">
                    <div class="card-header bg-transparent text-center text-dark">Grade</div>
                    <table class="table table-hover table-striped table-bordered w-30">
                        <thead>
                            <tr>
                                <!-- <th>S/N</th> -->
                                <th>Grade</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $row)
                            <tr>
                                <td>{{$row->grade}}</td>
                                <td>{{$row->title}}</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td>ND</td>
                                <td>Not Defined</td>
                            </tr>
                        </tbody>

                    </table>
                    @foreach($psycho as $row)
                    <div class="card-header text-center bg-transparent text-dark"><small>{{$row->psychomotor}}</small></div>
                    <table class="table table-hover table-striped table-bordered w-30">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($row->baseKey as $rw)
                            <tr>
                                <td> {{$rw->title}} </td>
                                <td>{{getPsychoKeyScore(student:$results->student_pid,param:$param,key:$rw->pid)}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="flex-row">
            <div class="section">
                <div class="card-header">Principal/Head Teacher</div>
                Name: {{$results->principal}}<br>
                Comment: {{$results->principal_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = $results->signature ? asset("/files/images/".$results->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$results->class_teacher}}<br>
                Comment: {{$results->class_teacher_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = $results->signature ? asset("/files/images/".$results->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>
            </div>
            @if($results->type==2)
            <div class="section">
                <div class="card-header">Class/Form Teacher</div>
                Name: {{$results->teacher}}<br>
                Comment: {{$results->portal_comment}}<br>
                <div class="signature-base">
                    @php $imgUrl = $results->signature ? asset("/files/images/".$results->signature) :'' @endphp
                    <img src="{{$imgUrl}}" alt="" class="img img-responsive signature">
                </div>

            </div>
            @endif
        </div>
        <div class="col-md-12">
            <div id="column_Chart" class="chartZoomable" style="width:90%;height:auto;"></div>
        </div>
        <button class="btn btn-success" id="printResult"> <i class="bi bi-printer"></i> </button>

    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.load('current', {
            'packages': ['bar']
        });

        google.charts.setOnLoadCallback(drawColumnChart);
        let dataset = <?php echo json_encode($columnChart, JSON_NUMERIC_CHECK) ?>
        // console.log(dataset);
        function drawColumnChart() {

            var data = google.visualization.arrayToDataTable(dataset);

            var view = new google.visualization.DataView(data);
            // view.setColumns([0, 4,
            //     {
            //         calc: "stringify",
            //         sourceColumn: 1,
            //         type: "string",
            //         role: "annotation"
            //     },
            //     3
            // ]);

            var options = {
                title: "Student Score Against total, MIN, MAX & AVG",
                // subtitle: "based on meter type and installation status",
                bar: {
                    groupWidth: "20%"
                },
                legend: {
                    position: "top"
                },
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("column_Chart"));
            chart.draw(view, options);
        }
    </script>
    <script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>
    <script src="{{asset('printThis/printThis.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#printResult').click(function() {
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