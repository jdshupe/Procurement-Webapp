$(document).ready(function () {
  // table sorter script
  $("#user-pageTable").tablesorter( {
    sortList: [[0,0]],
    headers: {
    },
    cssChildRow: "tablesorter-childrow",
    widgets: [ "zebra", "filter" ],
    widgetOptions: {
      filter_childRows : false,
      filter_cssFilter : 'tablesorter-filter',
      filter_excludeFilter: { 2: false}
    }
  });  
});