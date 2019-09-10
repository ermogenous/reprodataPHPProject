
//returns years from 2 dates from format dd/mm/yyyy
function getYearsFromDates(dateFrom, dateTo){

    var fromSplit = dateFrom.split('/');
    var toSplit = dateTo.split('/');

    var y1 = new Date(fromSplit[2] + '-' + fromSplit[1] + '-' + fromSplit[0]);
    var y2 = new Date(toSplit[2] + '-' + toSplit[1] + '-' + toSplit[0]);


    var result = Math.floor((y1-y2) / (365.25 * 24 * 60 * 60 * 1000));

    return result;
}


function getYearsFromDates(dFrom, dTo, whatToReturn = 'Years'){

    var fromSplit = dFrom.split('/');
    var toSplit = dTo.split('/');

    var dateTo = new Date(
        toSplit[2],
        toSplit[1],
        toSplit[0]
    );

    var yearNow = dateTo.getFullYear();
    var monthNow = dateTo.getMonth();
    var dateNow = dateTo.getDate();
    //date must be mm/dd/yyyy
    var dob = new Date(
        fromSplit[2],
        fromSplit[1],
        fromSplit[0]
    );

    var yearDob = dob.getFullYear();
    var monthDob = dob.getMonth();
    var dateDob = dob.getDate();
    var age = {};
    var ageString = '';
    var yearString = '';
    var monthString = '';
    var dayString = '';


    yearAge = yearNow - yearDob;

    if (monthNow >= monthDob)
        var monthAge = monthNow - monthDob;
    else {
        yearAge--;
        var monthAge = 12 + monthNow -monthDob;
    }

    if (dateNow >= dateDob)
        var dateAge = dateNow - dateDob;
    else {
        monthAge--;
        var dateAge = 31 + dateNow - dateDob;

        if (monthAge < 0) {
            monthAge = 11;
            yearAge--;
        }
    }

    age = {
        years: yearAge,
        months: monthAge,
        days: dateAge
    };

    if ( age.years > 1 ) yearString = " years";
    else yearString = " year";
    if ( age.months> 1 ) monthString = " months";
    else monthString = " month";
    if ( age.days > 1 ) dayString = " days";
    else dayString = " day";


    if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.years + yearString + ", " + age.months + monthString + ", and " + age.days + dayString + " old.";
    else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
        ageString = "Only " + age.days + dayString + " old!";
    else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
        ageString = age.years + yearString + " old. Happy Birthday!!";
    else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.years + yearString + " and " + age.months + monthString + " old.";
    else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
        ageString = age.months + monthString + " and " + age.days + dayString + " old.";
    else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
        ageString = age.years + yearString + " and " + age.days + dayString + " old.";
    else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
        ageString = age.months + monthString + " old.";
    else ageString = "Oops! Could not calculate age!";

    if (whatToReturn == 'Years'){
        return age.years;
    }
    if (whatToReturn == 'AgeString'){
        return ageString;
    }
    else {
        return age.years;
    }
}