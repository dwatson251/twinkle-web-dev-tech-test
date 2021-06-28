import $ from "jquery";
import BaseComponent from "../../Core/Component/BaseComponent";
import DashboardMiddleware from "../../Middleware/DashboardMiddleware";
import DashboardUserEdit from "./DashboardUserEdit";

export default class DashboardUserCreate extends BaseComponent
{
    constructor(elem) {
        super(elem);
        this.formElem = this.elem.find('form');
        this.formCtrlBlockElem = this.elem.find('.form-control-block');
        this.createBtnElem = this.formCtrlBlockElem.find('.create-btn');
        this.cancelBtnElem = this.formCtrlBlockElem.find('.cancel-btn');
        this.addListeners();
    }

    addListeners() {
        if (!this.elem) {
            return;
        }
        this.formElem.submit(this.onFormSubmit.bind(this));
        this.createBtnElem.click(this.onCreateClick.bind(this));
        this.cancelBtnElem.click(this.onCancelClick.bind(this));
    }

    onCreateClick(evt) {
        if (evt) {
            evt.preventDefault();
        }
        this.formElem.submit();
    }

    onCancelClick(evt) {
        if (evt) {
            evt.preventDefault();
        }
        this.elem.remove();
    }

    onFormSubmit(evt) {
        if (evt) {
            evt.preventDefault();
        }
        this.sendUserCreate();
    }

    sendUserCreate() {
        DashboardMiddleware.postUser(
            new FormData(this.formElem[0]),
            this.handleUserCreateSuccess.bind(this)
        );
    }

    handleUserCreateSuccess(userEditElem) {
        this.replaceWithEditWidget($(userEditElem));
    }

    replaceWithEditWidget(userEditElem) {
        this.elem.replaceWith(userEditElem);
        new DashboardUserEdit(userEditElem);
    }
}
