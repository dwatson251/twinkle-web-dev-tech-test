import $ from "jquery";
import BaseComponent from "../../Core/Component/BaseComponent";
import DashboardMiddleware from "../../Middleware/DashboardMiddleware";
import DashboardUserCreate from "./DashboardUserCreate";

export default class DashboardUserAdd extends BaseComponent {
    constructor(elem) {
        super(elem);
        this.formCtrlBlockElem = this.elem.find('.form-control-block');
        this.addBtn = this.formCtrlBlockElem.find('.add-btn');
        this.addListeners();
    }

    addListeners() {
        if (!this.elem) {
            return;
        }
        this.elem.click(this.onWidgetClick.bind(this));
    }

    onWidgetClick(evt) {
        if (evt) {
            evt.preventDefault();
        }
    }

    onGetUserCreateSuccess(userCreateElem) {
        this.prependUserCreateWidget($(userCreateElem));
    }

    prependUserCreateWidget(userCreateElem) {
        this.elem.before(userCreateElem);
        new DashboardUserCreate(userCreateElem);
    }
}
