import $ from "jquery";
import DashboardUserAdd from "./DashboardUserAdd";
import BaseComponent from "../../Core/Component/BaseComponent";
import DashboardUserEdit from "./DashboardUserEdit";

export default class Dashboard extends BaseComponent {
    constructor(elem) {
        super(elem);
        this.body = $('body');
        this.userEditElems = this.elem.find('.widget.dash-user-edit')
            .each(function (i, iDashUserEdit) {
                new DashboardUserEdit(iDashUserEdit);
            });
        this.userAddElem = this.elem.find('.widget.dash-user-add')
            .each(function (i, iDashUserAdd) {
                new DashboardUserAdd(iDashUserAdd);
            });
    }
}
