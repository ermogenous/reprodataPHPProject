
//returns years from 2 dates from format dd/mm/yyyy
function getYearsFromDates(dateFrom, dateTo){

    var fromSplit = dateFrom.split('/');
    var toSplit = dateTo.split('/');

    var y1 = new Date(fromSplit[2] + '-' + fromSplit[1] + '-' + fromSplit[0]);
    var y2 = new Date(toSplit[2] + '-' + toSplit[1] + '-' + toSplit[0]);


    var result = Math.floor((y1-y2) / (365.25 * 24 * 60 * 60 * 1000));

    return result;
}