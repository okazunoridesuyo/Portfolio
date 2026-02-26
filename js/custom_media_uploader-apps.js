//JSセクション
const js_section = document.querySelector('.add_js_file__select_file_section');
const add_js_btn = document.querySelector('#add_js_file__btn');
const remove_js_btn = document.querySelector('#remove_js_file__btn');

let json_data = null;

const data = {
    post_id: jsf_counter.post_id,
    count_js: jsf_counter.count_js,
    count_css: jsf_counter.count_css,
};

async function get_jsf_counter() {
    if (json_data) return json_data;

    const res = await fetch(
        jsf_counter.resturl + 'json_delivery/v1/receive-data',
        {
            headers: {
                'X-WP-Nonce': jsf_counter.nonce,
            },
        },
    );
    const json = await res.json();

    json_data = JSON.stringify(json.data);
    // console.log(data);
    return json_data;
}

async function post_jsf_counter() {
    try {
        const res = await fetch(
            jsf_counter.resturl + 'json_delivery/v1/receive-data',
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': jsf_counter.nonce,
                },
                body: JSON.stringify(data),
            },
        );
        const json = await res.json();
        console.log(json);
        return true;
    } catch (err) {
        console.error(err);
        return false;
    }
}
console.log(data['count_js']);
let js_file_url = [];
let div = [];
let label = [];
let input = [];
let button_select = [];
let button_delete = [];
let display_file_name = [];

let jsf_select_btn_arr = [];
let jsf_delete_btn_arr = [];

add_js_btn.addEventListener('click', () => {
    if (data['count_js'] < 10) {
        data['count_js']++;

        div[data['count_js']] = document.createElement('div');
        div[data['count_js']].className =
            'additional_js_file__section' + data['count_js'];
        div[data['count_js']].style.cssText =
            'border-bottom:1px solid black; padding:8px; margin-bottom:16px;';

        label[data['count_js']] = document.createElement('label');
        label[data['count_js']].htmlFor =
            'additional_js_file__input' + data['count_js'];
        label[data['count_js']].textContent =
            '追加JavaScriptファイル' + data['count_js'];
        label[data['count_js']].style.marginRight = '8px';

        input[data['count_js']] = document.createElement('input');
        input[data['count_js']].type = 'hidden';
        input[data['count_js']].value = js_file_url[data['count_js']] ?? '';
        input[data['count_js']].className =
            'additional_js_file__input' + data['count_js'];
        input[data['count_js']].name =
            'additional_js_file__input' + data['count_js'];

        button_select[data['count_js']] = document.createElement('button');
        button_select[data['count_js']].className =
            'additional_js_file__btn--select' + data['count_js'];
        button_select[data['count_js']].textContent = '選択';
        button_select[data['count_js']].style.marginRight = '8px';

        button_delete[data['count_js']] = document.createElement('button');
        button_delete[data['count_js']].className =
            'additional_js_file__btn--delete' + data['count_js'];
        button_delete[data['count_js']].textContent = '削除';
        button_delete[data['count_js']].style.marginRight = '8px';

        display_file_name[data['count_js']] = document.createElement('p');
        display_file_name[data['count_js']].className =
            'additional_js_file__display' + data['count_js'];
        const text = get_display_name(js_file_url[data['count_js']]);
        display_file_name[data['count_js']].textContent =
            'ファイル名： ' + text;

        post_jsf_counter()
            .then((success) => {
                if (success) {
                    console.log(data['count_js']);

                    div[data['count_js']].appendChild(label[data['count_js']]);
                    div[data['count_js']].appendChild(input[data['count_js']]);
                    div[data['count_js']].appendChild(
                        button_select[data['count_js']],
                    );
                    div[data['count_js']].appendChild(
                        button_delete[data['count_js']],
                    );
                    div[data['count_js']].appendChild(
                        display_file_name[data['count_js']],
                    );
                    js_section.appendChild(div[data['count_js']]);
                } else {
                    data['count_js']--;
                }
            })
            .then((res) => {
                get_jsf_select_element();
                select_js_file();
                delete_js_file();
            })
            .catch(() => {
                data['count_js']--;
                console.log('post error. js count: ' + data['count_js']);
            });
    }
});

remove_js_btn.addEventListener('click', () => {
    if (data['count_js'] > 0) {
        data['count_js']--;

        post_jsf_counter()
            .then((success) => {
                if (success) {
                    console.log(js_section.lastElementChild);
                    if (js_section.lastElementChild)
                        js_section.lastElementChild.remove();

                    console.log(data['count_js']);
                } else {
                    data['count_js']++;
                }
            })
            .catch(() => {
                data['count_js']++;
                console.log('post error. js count: ' + data['count_js']);
            });
    }
});

function get_jsf_select_element() {
    jsf_input_arr = document.querySelectorAll(
        "input[class^='additional_js_file__input']",
    );
    jsf_display_arr = document.querySelectorAll(
        "p[class^='additional_js_file__display']",
    );
    jsf_select_btn_arr = document.querySelectorAll(
        "button[class^='additional_js_file__btn--select']",
    );
    jsf_delete_btn_arr = document.querySelectorAll(
        "button[class^='additional_js_file__btn--delete']",
    );
}

function get_display_name(url = '') {
    return url !== '' && url != null
        ? url.substring(url.lastIndexOf('/') + 1)
        : '';
}

function get_element_classname_last_letter(elm) {
    return elm.className.slice(-1);
}

function select_js_file() {
    if (jsf_select_btn_arr) {
        jsf_select_btn_arr.forEach((btn, i) => {
            let mediaUploader;

            btn.addEventListener('click', (evt) => {
                evt.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                mediaUploader = wp.media({
                    title: 'メディアファイル選択',
                    button: {
                        text: '選択',
                    },
                    library: {
                        type: ['text/javascript', 'application/javascript'],
                    },
                    multiple: false,
                });

                const num = get_element_classname_last_letter(btn);

                mediaUploader.on('select', () => {
                    const attachment = mediaUploader
                        .state()
                        .get('selection')
                        .first()
                        .toJSON();
                    js_file_url[num] = attachment.url;
                    jsf_input_arr[i].setAttribute('value', js_file_url[num]);
                    jsf_display_arr[i].textContent =
                        'ファイル名： ' + get_display_name(js_file_url[num]);
                    console.log(jsf_input_arr[i].value);
                });

                mediaUploader.open();

                // console.log(js_file_url[num]);
            });
        });
    }
}

function delete_js_file() {
    if (jsf_delete_btn_arr) {
        jsf_delete_btn_arr.forEach((btn, i) => {
            btn.addEventListener('click', () => {
                const num = get_element_classname_last_letter(btn);

                jsf_input_arr[i].setAttribute('value', '');
                jsf_display_arr[i].textContent = 'ファイル名： ';

                js_file_url[num] = '';
            });
        });
    }
}

get_jsf_select_element();
select_js_file();
delete_js_file();

//CSSセクション
const css_section = document.querySelector('#add_css_file__section');
const add_css_file_section = document.querySelector(
    '.add_css_file__select_file_section',
);
let css_file_url = [];
let div_css = [];
let label_css = [];
let input_css = [];
let button_select_css = [];
let button_delete_css = [];
let display_file_name_css = [];

css_section.addEventListener('click', (e) => {
    const add_css_btn = e.target.closest('#add_css_file__btn');

    if (add_css_btn) {
        if (data['count_css'] < 10) {
            data['count_css']++;

            div_css[data['count_css']] = document.createElement('div');
            div_css[data['count_css']].className =
                'additional_css_file__section';
            div_css[data['count_css']].dataset.index = data['count_css'];
            div_css[data['count_css']].style.cssText =
                'border-bottom:1px solid black; padding:8px; margin-bottom:16px;';

            label_css[data['count_css']] = document.createElement('label');
            label_css[data['count_css']].htmlFor = 'additional_css_file__input';
            label_css[data['count_css']].dataset.index = data['count_css'];
            label_css[data['count_css']].textContent =
                '追加CSSファイル' + data['count_css'];
            label_css[data['count_css']].style.marginRight = '8px';

            input_css[data['count_css']] = document.createElement('input');
            input_css[data['count_css']].type = 'hidden';
            input_css[data['count_css']].value =
                css_file_url[data['count_css']] ?? '';
            input_css[data['count_css']].className =
                'additional_css_file__input';
            input_css[data['count_css']].dataset.index = data['count_css'];
            input_css[data['count_css']].name =
                'additional_css_file__input' + data['count_css'];

            button_select_css[data['count_css']] =
                document.createElement('button');
            button_select_css[data['count_css']].className =
                'additional_css_file__btn--select';
            button_select_css[data['count_css']].dataset.index =
                data['count_css'];
            button_select_css[data['count_css']].textContent = '選択';
            button_select_css[data['count_css']].style.marginRight = '8px';

            button_delete_css[data['count_css']] =
                document.createElement('button');
            button_delete_css[data['count_css']].className =
                'additional_css_file__btn--delete';
            button_delete_css[data['count_css']].dataset.index =
                data['count_css'];
            button_delete_css[data['count_css']].textContent = '削除';
            button_delete_css[data['count_css']].style.marginRight = '8px';

            display_file_name_css[data['count_css']] =
                document.createElement('p');
            display_file_name_css[data['count_css']].className =
                'additional_css_file__display';
            display_file_name_css[data['count_css']].dataset.index =
                data['count_css'];
            const text = get_display_name(css_file_url[data['count_css']]);
            display_file_name_css[data['count_css']].textContent =
                'ファイル名： ' + text;

            post_jsf_counter()
                .then((res) => {
                    if (res) {
                        console.log(data['count_css']);

                        div_css[data['count_css']].appendChild(
                            label_css[data['count_css']],
                        );
                        div_css[data['count_css']].appendChild(
                            input_css[data['count_css']],
                        );
                        div_css[data['count_css']].appendChild(
                            button_select_css[data['count_css']],
                        );
                        div_css[data['count_css']].appendChild(
                            button_delete_css[data['count_css']],
                        );
                        div_css[data['count_css']].appendChild(
                            display_file_name_css[data['count_css']],
                        );
                        add_css_file_section.appendChild(
                            div_css[data['count_css']],
                        );
                    } else {
                        data['count_css']--;
                    }
                })
                .catch(() => {
                    data['count_css']--;
                    console.log('post error. css count: ' + data['count_css']);
                });
        }
    }

    const remove_css_btn = e.target.closest('#remove_css_file__btn');
    if (remove_css_btn) {
        if (data['count_css'] > 0) {
            data['count_css']--;

            post_jsf_counter()
                .then((res) => {
                    if (res) {
                        if (add_css_file_section.lastElementChild)
                            add_css_file_section.lastElementChild.remove();
                        console.log(data['count_css']);
                    } else {
                        data['count_css']++;
                    }
                })
                .catch(() => {
                    data['count_css']++;
                    console.log('post error. css count: ' + data['count_css']);
                });
        }
    }

    const css_select_btn = e.target.closest(
        '.additional_css_file__btn--select',
    );
    const css_delete_btn = e.target.closest(
        '.additional_css_file__btn--delete',
    );
    const css_input = e.target.parentElement.querySelector(
        '.additional_css_file__input',
    );
    const css_display_name = e.target.parentElement.querySelector(
        '.additional_css_file__display',
    );

    const index = e.target.dataset.index;
    let mediaUploader;

    if (css_select_btn) {
        console.log('select:' + index);

        e.preventDefault();

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'メディアファイル選択',
            button: {
                text: '選択',
            },
            library: {
                type: 'text/css',
            },
            multiple: false,
        });

        mediaUploader.on('select', () => {
            const attachment = mediaUploader
                .state()
                .get('selection')
                .first()
                .toJSON();
            css_file_url[index] = attachment.url;
            css_input.setAttribute('value', css_file_url[index]);
            css_display_name.textContent =
                'ファイル名： ' + get_display_name(css_file_url[index]);
        });

        mediaUploader.open();

        // console.log(css_file_url[num]);
    }

    if (css_delete_btn) {
        console.log('delete:' + index);

        css_input.setAttribute('value', '');
        css_display_name.textContent = 'ファイル名： ';
        css_file_url[index] = '';
    }
});
