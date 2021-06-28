import $ from "jquery";
import BaseComponent from "../../Core/Component/BaseComponent";
import DashboardMiddleware from "../../Middleware/DashboardMiddleware";

export default class DashboardUserEdit extends BaseComponent
{
    constructor(elem)
    {
        super(elem);
        this.formElem = this.elem.find('form');
        this.formCtrlBlockElem = this.elem.find('.form-control-block');
        this.deleteBtnElem = this.formCtrlBlockElem.find('.delete-btn');
        this.addListeners();
    }

    addListeners() {
        if (!this.elem) {
            return;
        }
        this.deleteBtnElem.click(this.onDeleteClick.bind(this));
    }

    onDeleteClick(evt) {
        if (evt) {
            evt.preventDefault();
        }
        this.sendDeleteUser();
    }

    sendDeleteUser() {
        DashboardMiddleware.deleteUser(this.elem.data('userId'), this.handleDeleteUserSuccess.bind(this));
    }

    handleDeleteUserSuccess() {
        this.elem.remove();
    }
}
