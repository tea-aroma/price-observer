import { InputType } from './InputType.js';


/**
 * Contains all possible settings for the Input component.
 */
export class InputSettings
{
    /**
     * @typedef { Object } InputSettingInterface
     *
     * @property { HTMLFormElement? } domElement
     *
     * @property { string? } domElementClassName
     *
     * @property { string? } domLabelClassName
     *
     * @property { string? } domOuterClassName
     *
     * @property { string? } label
     *
     * @property { string? } id
     *
     * @property { string? } name
     *
     * @property { string? } placeholder
     *
     * @property { boolean? } hidden
     *
     * @property { boolean? } disabled
     *
     * @property { ('on' | 'off')? } autocomplete
     *
     * @property { string? } value
     *
     * @property { InputType? } type
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
    domElementClassName = 'form__input';

    /**
     * @public
     *
     * @type { string }
     */
    domLabelClassName = 'form__label';

    /**
     * @public
     *
     * @type { string }
     */
    domOuterClassName = 'form__outer';

    /**
     * @public
     *
     * @type { string }
     */
    label;

    /**
     * @public
     *
     * @type { string }
     */
    id;

    /**
     * @public
     *
     * @type { string }
     */
    name;

    /**
     * @public
     *
     * @type { string }
     */
    placeholder;

    /**
     * @public
     *
     * @type { boolean }
     */
    hidden = false;

    /**
     * @public
     *
     * @type { boolean }
     */
    disabled = false;

    /**
     * @public
     *
     * @type { 'on' | 'off' }
     */
    autocomplete = 'off';

    /**
     * @public
     *
     * @type { string }
     */
    value;

    /**
     * @public
     *
     * @type { InputType }
     */
    type = InputType.TEXT;

    /**
     * @constructor
     *
     * @param { InputSettingInterface } settings
     */
    constructor(settings)
    {
        Object.assign(this, settings);
    }
}
