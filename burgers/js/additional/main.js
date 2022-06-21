import { orderFormSubmitHandler } from './order-form.js';

const ORDER_SUBMIT_BUTTON = document.querySelector('.order__form-button');
ORDER_SUBMIT_BUTTON.addEventListener('click', orderFormSubmitHandler);
