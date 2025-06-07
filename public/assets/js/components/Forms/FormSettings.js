/**
 * Provides all possible settings for the Form component.
 */
export class FormSettings
{
    /**
     * @typedef { Object } FormSettingInterface
     *
     * @property { HTMLFormElement? } domElement
     *
     * @property { string? } domElementClassName
     *
     * @property { string? } domButtonClassName
     *
     * @property { string? } buttonText
     *
     * @property { Array<FormItemInterface>? } items
     *
     * @property { boolean? } withoutButton
     */

    /**
     * @typedef { TextInputSettingInterface } FormItemInterface
     */

    /**
     * @public
     *
     * @type { HTMLFormElement }
     */
    domElement;

    /**
     * @public
     *
     * @type { string }
     */
    domElementClassName = 'form form--style-default form--type-default';

    /**
     * @public
     *
     * @type { string }
     */
    domButtonClassName = 'form__button';

    /**
     * @public
     *
     * @type { string }
     */
    buttonText = 'Submit';

    /**
     * @public
     *
     * @type { Array<FormItemInterface> }
     */
    items = [];

    /**
     * @public
     *
     * @type { boolean }
     */
    withoutButton = false;

    /**
     * @constructor
     */
    constructor(settings)
    {
        Object.assign(this, settings);
    }
}
