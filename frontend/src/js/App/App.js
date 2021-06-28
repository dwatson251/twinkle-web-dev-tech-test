import $ from 'jquery';
import DashboardUserAdd from "../Dashboard/Component/DashboardUserAdd";
import Dashboard from "../Dashboard/Component/Dashboard";

export default class App
{
    constructor()
    {
        this.bodyElem = $('body');
        this.bodyElem.find('.widget.widget-block.dash')
            .each(function (i, iDashUserCreate) {
                new Dashboard(iDashUserCreate);
            });
    }
}
