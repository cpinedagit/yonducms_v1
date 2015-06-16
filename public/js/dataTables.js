 $(document).ready(function() {
                $('.dtable').DataTable({
                    aaSorting: [0],
                    bInfo: false,
                    columnDefs: [
                       { orderable: false, targets: 0 },
                       { orderable: false, targets: -1 }
                    ],
                    "dom":'<"top">rt<"bottom"lp>',
                    "oLanguage": {
                        "sSearch": "<span class='lbl-filter'>Search</span> ",
                        "oPaginate": {
                            "sPrevious": '<i class="fa fa-chevron-left"></i>',
                            "sNext": '<i class="fa fa-chevron-right"></i>'
                        }
                        
                    }
                });

                 $('.superTable').DataTable({
                    aaSorting: [0],
                    bInfo: false,
                    columnDefs: [
                       { orderable: false, targets: 0 },
                        { orderable: false, targets: 1 },
                       { orderable: false, targets: -1 }
                    ],
                    "dom":'<"top"f>rt<"bottom"lp>',
                    "oLanguage": {
                        "sSearch": "<span class='lbl-filter'>Search</span> ",
                        "oPaginate": {
                            "sPrevious": '<i class="fa fa-chevron-left"></i>',
                            "sNext": '<i class="fa fa-chevron-right"></i>'
                        }
                        
                    }
                });
            } );