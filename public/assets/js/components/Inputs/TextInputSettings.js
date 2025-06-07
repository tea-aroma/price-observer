import { InputSettings } from './InputSettings.js';


/**
 * @inheritDoc
 */
export class TextInputSettings extends InputSettings
{
    /**
     * @typedef { InputSettingInterface } TextInputSettingInterface
     *
     * @property { InputType? } type
     */

    /**
     * @public
     *
     * @type { InputType }
     */
    type;

    /**
     * @constructor
     *
     * @param { TextInputSettingInterface } settings
     */
    constructor(settings)
    {
        super(settings);

        Object.assign(this, settings);
    }
}
