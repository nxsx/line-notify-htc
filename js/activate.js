const formactivate = document.querySelector("#form-activate");
const empid = document.querySelector("#empid");
const btnsubmit = document.querySelector("#btnsubmit");
const displaylist = document.querySelector("#displaylist");
const listbody = document.querySelector("#listbody");

const formkeycode = document.querySelector("#form-keycode");
const refdisplay = document.querySelector("#refdisplay");
const otpinput = document.querySelector("#otpinput");
const otpsubmit = document.querySelector("#otpsubmit");
const otpcancel = document.querySelector("#otpcancel");

let local = {};

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

const setActivation = (e, token, keycode) => {
        e.preventDefault();

        const url = './php/operations.php';
        const req = {
                token: token,
                keycode: keycode
        };
        
        fetchPost(url, req).then(data => {
                local.data = data;
                local.link = 'http://190.7.10.27/wmsapi/linenotify/setactivated.php';
                refdisplay.textContent = local.data.ref;

                formactivate.style.display = "none";
                displaylist.style.display = "none";
                formkeycode.style.display = "block";
        }).catch(error => {
                console.log(error);
        }).finally(() => {
                setTimeout(() => {
                        local = {};
                        refdisplay.textContent = '';

                        formkeycode.style.display = "none";
                        formkeycode.reset();

                        formactivate.style.display = "block";
                        getRegisterList(empid.value);
                }, 180000);
        });
};

const setInactivation = (e, token, keycode) => {
        e.preventDefault();

        const url = './php/operations.php';
        const req = {
                token: token,
                keycode: keycode
        };
        
        fetchPost(url, req).then(data => {
                local.data = data;
                local.link = 'http://190.7.10.27/wmsapi/linenotify/setinactivated.php';
                refdisplay.textContent = local.data.ref;

                formactivate.style.display = "none";
                displaylist.style.display = "none";
                formkeycode.style.display = "block";
        }).catch(error => {
                console.log(error);
        }).finally(() => {
                setTimeout(() => {
                        local = {};
                        refdisplay.textContent = '';

                        formkeycode.style.display = "none";
                        formkeycode.reset();

                        formactivate.style.display = "block";
                        getRegisterList(empid.value);
                }, 180000);
        });
};

const setDeleteCode = (e, token, keycode) => {
        e.preventDefault();

        const url = './php/operations.php';
        const req = {
                token: token,
                keycode: keycode
        };
        
        fetchPost(url, req).then(data => {
                local.data = data;
                local.link = 'http://190.7.10.27/wmsapi/linenotify/setdeleted.php';
                refdisplay.textContent = local.data.ref;

                formactivate.style.display = "none";
                displaylist.style.display = "none";
                formkeycode.style.display = "block";
        }).catch(error => {
                console.log(error);
        }).finally(() => {
                setTimeout(() => {
                        local = {};
                        refdisplay.textContent = '';

                        formkeycode.style.display = "none";
                        formkeycode.reset();

                        formactivate.style.display = "block";
                        getRegisterList(empid.value);
                }, 180000);
        });
};

const getTypeDesc = (type) => {
        switch (type) {
                case "PS":
                        return "Department";
                        break;
                case "DV":
                        return "Division";
                        break;
                default:
                        return "Group Division";
        }
};

const getStatusDesc = (status) => {
        switch (status) {
                case "1":
                        return "Activated";
                        break;
                default:
                        return "Inactivated";
        }
};

const getLinkActivation = (status, token, keycode) => {
        switch (status) {
                case "1":
                        return `<a class="stop pointer" onclick="setInactivation(event, '${token}', '${keycode}')"><i class="fa fa-stop" aria-hidden="true"></i></a> |`;
                        break;
                default:
                        return `<a class="start pointer" onclick="setActivation(event, '${token}', '${keycode}')"><i class="fa fa-play" aria-hidden="true"></i></a> |`;
        }
};

const getRegisterList = (id) => {
        const url = `http://190.7.10.27/wmsapi/linenotify/registerlist.php?id=${id}`;
        fetchGet(url).then(data => {
                listbody.innerHTML = '';

                if (data.length === 0) {
                        displaylist.style.display = "none";
                } else {
                        for (let i = 0; i < data.length; i++) {
                                const key = data[i];
                                const row = `
                                <tr>
                                        <td>${i+1}</td>
                                        <td>${getTypeDesc(key.send_type)}</td>
                                        <td class="fwidth">${key.send_desc}</td>
                                        <td>${getStatusDesc(key.send_active)}</td>
                                        <td>
                                                ${getLinkActivation(key.send_active, key.send_token, key.keycode)}
                                                <a class="delete pointer" onclick="setDeleteCode(event, '${key.send_token}', '${key.keycode}')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                </tr>
                                `;
                                listbody.innerHTML += row;
                        }
                        displaylist.style.display = "block";
                }
        }).catch(error => {
                console.log(error);
        });
};

formactivate.addEventListener('submit', (e) => {
        e.preventDefault();
        
        if (empid.value || '') {
                getRegisterList(empid.value);
        }
});

empid.addEventListener('keypress', (e) => {
        if (e.keyCode === 13) {
                e.preventDefault();
                btnsubmit.click();
        }
});

const getVerifyOtp = (key, local, input, url) => {
        const req = {
                key: key
        };

        if (local === input) {
                fetchPost(url, req).then(data => {
                        alert(data.text);
                }).catch(error => {
                        console.log(error);
                }).finally(() => {
                        local = {};
                        refdisplay.textContent = '';

                        formkeycode.style.display = "none";
                        formkeycode.reset();

                        formactivate.style.display = "block";
                        empid.focus();
                        getRegisterList(empid.value);
                });
        } else {
                alert("You have input wrong OTP, try again please.");
        }
};

formkeycode.addEventListener('submit', (e) => {
        e.preventDefault();

        const set = {
                key: local.data.key.toString(),
                local: local.data.otp.toString(),
                input: otpinput.value.toString(),
                url: local.link.toString()
        };

        if (otpinput.value || '') {
                getVerifyOtp(set.key, set.local, set.input, set.url);
        }
});

otpinput.addEventListener('keypress', (e) => {
        if (e.keyCode === 13) {
                e.preventDefault();
                otpsubmit.click();
        }
});

otpcancel.addEventListener('click', () => {
        formactivate.reset();
        location.reload();
});
