import $ from 'jquery';

export default class BaseComponent
{
    constructor(elem)
    {
        this.elem = $(elem);
    }
}