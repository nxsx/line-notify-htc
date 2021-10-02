const form = document.querySelector("#form-register");
const empid = document.querySelector("#empid");
const empname = document.querySelector("#empname");
const emptoken = document.querySelector("#emptoken");
const messageform = document.querySelector("#messageform");
const messagetype = document.querySelector("#messagetype");
const typecode = document.querySelector("#typecode");
const btnsubmit = document.querySelector("#btnsubmit");
const msgcallback = document.querySelector("#msgCallback");

const daybox = {
        monday: document.querySelector("#isMonday"),
        tuesday: document.querySelector("#isTuesday"),
        wednesday: document.querySelector("#isWednesday"),
        thursday: document.querySelector("#isThursday"),
        friday: document.querySelector("#isFriday"),
        saturday: document.querySelector("#isSaturday"),
        sunday: document.querySelector("#isSunday")
};

const dayspan = {
        monday: document.querySelector("#forMonday"),
        tuesday: document.querySelector("#forTuesday"),
        wednesday: document.querySelector("#forWednesday"),
        thursday: document.querySelector("#forThursday"),
        friday: document.querySelector("#forFriday"),
        saturday: document.querySelector("#forSaturday"),
        sunday: document.querySelector("#forSunday")
};

const checkByDays = (day, check) => {
        day.addEventListener('click', (e) => {
                e.preventDefault();
                (check.checked) ? check.removeAttribute('checked') : check.setAttribute('checked', '');
        });
};

checkByDays(dayspan.monday, daybox.monday);
checkByDays(dayspan.tuesday, daybox.tuesday);
checkByDays(dayspan.wednesday, daybox.wednesday);
checkByDays(dayspan.thursday, daybox.thursday);
checkByDays(dayspan.friday, daybox.friday);
checkByDays(dayspan.saturday, daybox.saturday);
checkByDays(dayspan.sunday, daybox.sunday);

const detailType = [
        { id: 'PS', name: 'Department' },
        { id: 'DV', name: 'Division' }
];

const summaryType = [
        { id: 'DV', name: 'Division' },
        { id: 'GV', name: 'Group Division' }
];

const fetchGet = async (url) => {
        const response = await fetch(url);
        const data = await response.json();
        return data;
};

const fetchPost = async (url, req) => {
        const response = await fetch(url, {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: JSON.stringify(req)
        });
        const data = await response.json();
        return data;
};

const setOption = (select, options) => {
        select.innerHTML = '';

        const defaultoption = document.createElement('option');
        defaultoption.textContent = "Please select options .....";
        select.appendChild(defaultoption);

        options.map(type => {
                const option = document.createElement('option');

                option.value = type.id;
                option.textContent = type.name;

                select.appendChild(option);
        });

        select.removeAttribute('disabled');
};

const sendCongrats = (token, desc) => {
        const url = './php/congrats.php';
        const req = {
                token: token,
                desc: desc
        };

        fetchPost(url, req).then(data => {
                console.log(data);
        }).catch(error => {
                console.log(error);
        });
};

const setTypeUri = (type) => {
        switch (type) {
                case 'PS':
                        return 'http://190.7.10.27/wmsapi/linenotify/process.php';
                        break;
                case 'DV':
                        return 'http://190.7.10.27/wmsapi/linenotify/division.php';
                        break;
                default:
                        return 'http://190.7.10.27/wmsapi/linenotify/groupdivision.php';
        }
};

messageform.addEventListener('change', (e) => {
        e.preventDefault();

        if (e.target.value == '') {
                messagetype.setAttribute('disabled', '');
                typecode.setAttribute('disabled', '');
        } else {
                if (e.target.value == '1') {
                        setOption(messagetype, detailType);
                } else {
                        setOption(messagetype, summaryType);
                }
        }
});

messagetype.addEventListener('change', (e) => {
        e.preventDefault();

        if (e.target.value == '') {
                typecode.setAttribute('disabled', '');
        } else {
                const url = setTypeUri(e.target.value);
                
                fetchGet(url).then(data => {
                        setOption(typecode, data);
                }).catch(error => {
                        console.log(error)
                });
        }
});

form.addEventListener('submit', (e) => {
        e.preventDefault();

        const url = 'http://190.7.10.27/wmsapi/linenotify/register.php';
        const { monday, tuesday, wednesday, thursday, friday, saturday, sunday } = daybox;
        const req = {
                empid: empid.value,
                empname: empname.value,
                emptoken: emptoken.value,
                messageform: messageform.value,
                messagetype: messagetype.value,
                typecode: typecode.value,
                typename: typecode.options[typecode.selectedIndex].text,
                monday: (monday.checked) ? 1 : 0,
                tuesday: (tuesday.checked) ? 1 : 0,
                wednesday: (wednesday.checked) ? 1 : 0,
                thursday: (thursday.checked) ? 1 : 0,
                friday: (friday.checked) ? 1 : 0,
                saturday: (saturday.checked) ? 1 : 0,
                sunday: (sunday.checked) ? 1 : 0
        };

        fetchPost(url, req).then(data => {
                form.reset();
                form.style.display = "none";
                msgcallback.innerHTML = data.message;
                msgcallback.style.display = "block";
        }).catch(error => {
                console.log(error);
        }).finally(() => {
                sendCongrats(req.emptoken, req.typename);
        });
});
