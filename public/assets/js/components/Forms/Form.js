import { FormSettings } from './FormSettings.js';
import { createHtmlElement } from '../../Standards/functions/createHtmlElement.js';
import { InputType } from '../Inputs/InputType.js';
import { TextInput } from '../Inputs/TextInput.js';
import { CustomEvents } from '../../standards/Events/CustomEvents.js';
import { FormEvent } from './FormEvent.js';


/**
 * Provides the logic for forms.
 */
export class Form
{
    /**
     * @typedef { TextInput } FormItem
     */

    /**
     * @public
     *
     * @type { CustomEvents }
     */
    customEvents = new CustomEvents();

    /**
     * @protected
     *
     * @type { HTMLFormElement }
     */
    _domElement;

    /**
     * @protected
     *
     * @type { HTMLButtonElement }
     */
    _domButton;

    /**
     * @protected
     *
     * @type { FormSettings }
     */
    _settings;

    /**
     * @protected
     *
     * @type { Map<string, FormItem> }
     */
    _items = new Map();

    /**
     * @param { FormSettingInterface } settings
     */
    constructor(settings)
    {
        this._settings = settings instanceof FormSettings ? settings : new FormSettings(settings);
    }

    /**
     * @public
     *
     * @return { void }
     */
    initialization()
    {
        this._domButton = this._createDomButton();

        this._domElement = this._createDomElement();

        this._domElement.addEventListener('click', this._submitHandler.bind(this));

        this._domElement.addEventListener('change', this._enterHandler.bind(this));

        this._build();
    }

    /**
     * Handles the event of the 'submit'.
     *
     * @protected
     *
     * @param { PointerEvent } event
     *
     * @return { void }
     */
    _submitHandler(event)
    {
        const button = event.target.closest('.' + this._settings.domButtonClassName);

        if (!button)
        {
            return;
        }

        this.customEvents.execute(FormEvent.SUBMIT, event);
    }

    /**
     * Handles the event of the 'enter'.
     *
     * @protected
     *
     * @param { PointerEvent } event
     *
     * @return { void }
     */
    _enterHandler(event)
    {
        this.customEvents.execute(FormEvent.ENTER, event);
    }

    /**
     * Creates a dom element.
     *
     * @protected
     *
     * @return { HTMLFormElement }
     */
    _createDomElement()
    {
        const children = [];

        if (!this._settings.withoutButton)
        {
            children.push(this._domButton);
        }

        return createHtmlElement('form', { class: this._settings.domElementClassName }, children);
    }

    /**
     * Creates a dom button.
     *
     * @protected
     *
     * @return { HTMLButtonElement }
     */
    _createDomButton()
    {
        return createHtmlElement('button', { class: this._settings.domButtonClassName, type: 'button' }, [ new Text(this._settings.buttonText) ]);
    }

    /**
     * Builds inputs.
     *
     * @protected
     *
     * @return { void }
     */
    _build()
    {
        const fragment = document.createDocumentFragment();

        for (let i = 0, n = this._settings.items.length; i < n; i++)
        {
            const item = this._settings.items[ i ];

            const instance = this._getInputInstanceByType(item.type, item);

            instance.initialization();

            fragment.append(instance.getDomOuter());

            this._items.set(instance.getId(), instance);
        }

        this._domElement.prepend(fragment);
    }

    /**
     * Creates an instance by specified type with specified settings.
     *
     * @protected
     *
     * @param { InputType } type
     * @param { FormItemInterface } settings
     *
     * @return { FormItem }
     */
    _getInputInstanceByType(type, settings)
    {
        switch (type)
        {
            default: return new TextInput(settings);
        }
    }

    /**
     * Gets the dom element.
     *
     * @public
     *
     * @return { HTMLFormElement }
     */
    getDomElement()
    {
        return this._domElement;
    }

    /**
     * Appends the specified item.
     *
     * @public
     *
     * @param { FormItem } item
     *
     * @return { void }
     */
    append(item)
    {
        this._items.set(item.getId(), item);
    }

    /**
     * Gets an item by the specified id.
     *
     * @public
     *
     * @return { FormItem }
     */
    getItem(id)
    {
        return this._items.get(id);
    }

    /**
     * Converts instance to json.
     *
     * @public
     *
     * @return { string }
     */
    toJson()
    {
        return JSON.stringify(this.toObject());
    }

    /**
     * Converts instance to json.
     *
     * @public
     *
     * @return { string }
     */
    toObject()
    {
        const values = {};

        for (const [ id, input ] of this._items)
        {
            values[ input.getName() ] = input.getValue();
        }

        return values;
    }

    /**
     * Validates the form.
     *
     * @public
     *
     * @return { boolean }
     */
    validate()
    {
        for (const [ id, input ] of this._items)
        {
            if (!input.getValue())
            {
                return false;
            }
        }

        return true;
    }

    /**
     * Clears item values.
     *
     * @public
     *
     * @return { void }
     */
    clear()
    {
        this._items.forEach(item => item.clear());
    }
}
