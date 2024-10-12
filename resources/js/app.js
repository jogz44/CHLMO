import './bootstrap';
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
import 'simple-notify/dist/simple-notify.css';
import Notify from 'simple-notify';

window.Notify = Notify;

window.pushNotification = function (status, title, text) {
    new Notify({
        status: status,
        title: title,
        text: text,
        effect: 'fade',
        speed: 300,
        customClass: null,
        customIcon: null,
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 10000,
        gap: 20,
        distance: 20,
        type: 'outline',
        position: 'right top',
    });
}