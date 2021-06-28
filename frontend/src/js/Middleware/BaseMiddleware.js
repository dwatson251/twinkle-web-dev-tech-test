import $ from 'jquery';
import HttpConsts from "../Core/Consts/HttpConsts";

export default class BaseMiddleware
{
    static get(
        url,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        $.get(
            this.parseAjaxSettings(url, null, successHandler, errorHandler, ajaxSettings)
        );
    }

    static post(
        url,
        data = null,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        $.post(
            this.parseAjaxSettings(...[null, ...arguments])
        );
    }

    static put(
        url,
        data = null,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        $.ajax(
            this.parseAjaxSettings(...["PUT", ...arguments])
        );
    }

    static patch(
        url,
        data = null,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        $.ajax(
            this.parseAjaxSettings(...["PATCH", ...arguments])
        );
    }

    static delete(
        url,
        data = null,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        $.ajax(
            this.parseAjaxSettings(...["DELETE", ...arguments])
        );
    }

    static parseAjaxSettings(
        method,
        url,
        data = null,
        successHandler = null,
        errorHandler = null,
        ajaxSettings = null
    ) {
        ajaxSettings = ajaxSettings || {};

        if (typeof url === "string") {
            ajaxSettings.url = url;
        }
        if (ajaxSettings.url == null) {
            throw new Error("URL is not defined!");
        }

        ajaxSettings = Object.assign(
            ajaxSettings,
            {
                method: method || ajaxSettings.method,
                data: data || ajaxSettings.data,
                success: successHandler || (ajaxSettings.success || this.onSuccess.bind(this)),
                error: errorHandler || (ajaxSettings.error || this.onError.bind(this)),
            }
        );
        if (ajaxSettings.data instanceof FormData) {
            ajaxSettings.processData = false;
            ajaxSettings.contentType = false;
        }
        return ajaxSettings;
    }

    static mergeAjaxSettingsMethod(ajaxSettings, method) {
        ajaxSettings = ajaxSettings || {};
        return {...ajaxSettings, ...{method: method}};
    }

    static onSuccess(data, textStatus, jqXhr) {
        this.isResponseJson(jqXhr) ?
            this.handleJsonSuccess(...arguments)
            : this.handleHtmlSuccess(...arguments);
    }

    static handleJsonSuccess(data, textStatus, jqXhr) {
        let successMsg = "Success!";

        try {
            successMsg = data.message || successMsg;
        } catch (err) {
            // do nothing
        }

        alert(successMsg);
    }

    static handleHtmlSuccess(data, textStatus, jqXhr) {
        let successMsg = "Success!";

        try {
            successMsg = data || "";
            if (successMsg.trim() === "") {
                successMsg = jqXhr.responseXML || jqXhr.responseText;
            }
        } catch (err) {
            // do nothing
        }

        alert(successMsg);
    }

    static onError(jqXhr, textStatus, errorThrown) {
        this.isResponseJson(jqXhr) ?
            this.handleJsonError(...arguments)
            : this.handleHtmlError(...arguments);
    }

    static handleJsonError(jqXhr, textStatus, errorThrown) {
        let errMsg = `Unknown error. | Text Status: ${textStatus} | Error Thrown: ${errorThrown}`;

        try {
            data = JSON.parse(jqXhr.responseText);
            errMsg = data.message;
        } catch (err) {
            // do nothing
        }

        alert(errMsg);
    }

    static handleHtmlError(jqXhr, textStatus, errorThrown) {
        let errMsg = `Unknown error. | Text Status: ${textStatus} | Error Thrown: ${errorThrown}`;

        try {
            errMsg = jqXhr.responseXML || jqXhr.responseText;
        } catch (err) {
            // do nothing
        }

        alert(errMsg);
    }

    static isResponseJson(jqXhr) {
        return jqXhr.getResponseHeader(HttpConsts.CONTENT_TYPE_JSON) === HttpConsts.CONTENT_TYPE_JSON;
    }
}