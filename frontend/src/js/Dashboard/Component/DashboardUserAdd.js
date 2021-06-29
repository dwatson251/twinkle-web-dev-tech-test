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
        /**
         * Obvious misspelling, however unclear usage even compared to other components.
         */
        this.elem.click(this.onWidgetClick.bind(this));
    }

    onWidgetClick(evt) {
        if (evt) {
            evt.preventDefault();
        }
    }

    /**
     * Method name does not suggest intentions? Is this the bug?
     */
    onGetUserCreateSuccess(userCreateElem) {
        this.prependUserCreateWidget($(userCreateElem));
    }

    prependUserCreateWidget(userCreateElem) {
        /**
         * Result of method "before" not used, however does not appear to fix the issue when placed as an argument to
         * the DashboardUserCreate constructor.
         *
         * It is not clear what value the constructor requires.
         */
        this.elem.before(userCreateElem);
        new DashboardUserCreate(userCreateElem);
    }
}
