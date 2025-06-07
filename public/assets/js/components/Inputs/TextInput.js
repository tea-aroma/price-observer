import { Input } from './Input.js';
import { createHtmlElement } from '../../standards/functions/createHtmlElement.js';
import { InputSettings } from './InputSettings.js';
import { TextInputSettings } from './TextInputSettings.js';


/**
 * @inheritDoc
 */
export class TextInput extends Input
{
    /**
     * @constructor
     *
     * @param { TextInputSettingInterface } settings
     */
    constructor(settings)
    {
        super(settings);

        this._settings = settings instanceof InputSettings ? settings : new TextInputSettings(settings);
    }

    /**
     * @inheritDoc
     *
     * @return { HTMLDivElement }
     */
    _createDomElement()
    {
        const attributes = {};

        for (const key in this._settings)
        {
            const value = this._settings[ key ];

            if (!value || this.getIgnoredSettings().includes(key))
            {
                continue;
            }

            attributes[ key ] = this._settings[ key ];
        }

        attributes.type = this._settings.type;

        attributes.class = this._settings.domElementClassName;

        return createHtmlElement('input', attributes);
    }
}
