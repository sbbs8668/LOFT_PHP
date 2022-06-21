import { fetchApi } from './api-fetch.js';

const ORDER_FORM = document.querySelector('#order-form');
const RESPONSE_CONTAINER = document.createElement('div');
RESPONSE_CONTAINER.id = 'response_container';
RESPONSE_CONTAINER.style.color= '#fff';
RESPONSE_CONTAINER.style.textAlign= 'center';
ORDER_FORM.parentNode.insertBefore(RESPONSE_CONTAINER, ORDER_FORM.nextSibling);

const proceedOrderAfterApiResponse = (apiResponse) => {
    RESPONSE_CONTAINER.innerHTML = '';
    apiResponse = JSON.parse(apiResponse);
    apiResponse.forEach((line) => {
        const RESPONSE_LINE = document.createElement('p');
        RESPONSE_LINE.textContent = line;
        RESPONSE_CONTAINER.append(RESPONSE_LINE);
    })
}
const processOrderForm = (ORDER_DATA) => {
    fetchApi(ORDER_DATA).then((apiResponse) => {
        proceedOrderAfterApiResponse(apiResponse);
    });
}
const orderFormSubmitHandler = (ev) => {
    ev.preventDefault();
    const ORDER_DATA = new FormData(ORDER_FORM);
    processOrderForm(ORDER_DATA);
}

export { orderFormSubmitHandler };
