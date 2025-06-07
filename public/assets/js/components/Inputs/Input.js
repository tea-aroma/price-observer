import { CustomEvents } from '../../standards/Events/CustomEvents.js';
import { InputSettings } from './InputSettings.js';
import { createHtmlElement } from '../../standards/functions/createHtmlElement.js';


/**
 * Provides the abstract logic for Input components.
 */
export class Input
{
    /**
     * @public
     *
     * @type { CustomEvents }
     */
    customEvents = new CustomEvents();

    /**
     * @protected
     *
     * @type { HTMLElement }
     */
    _domElement;

    /**
     * @protected
     *
     * @type { HTMLDivElement }
     */
    _domOuter;

    /**
     * @protected
     *
     * @type { HTMLLabelElement }
     */
    _domLabel;

    /**
     * @protected
     *
     * @type { InputSettingInterface }
     */
    _settings;

    /**
     * @constructor
     *
     * @param { InputSettingInterface } settings
     */
    constructor(settings)
    {
        this._settings = settings instanceof InputSettings ? settings : new InputSettings(settings);
    }

    /**
     * Initializes the base logic.
     *
     * @public
     *
     * @return { void }
     */
    initialization()
    {
        this._domElement = this._settings.domElement || this._createDomElement();

        this._domElement.addEventListener('change', this._changeHandler.bind(this));

        this._domElement.addEventListener('input', this._changeHandler.bind(this));

        this._domLabel = this._createDomLabel();

        this._domOuter = this._createDomOuter();
    }

    /**
     * Handles the change event.
     *
     * @protected
     *
     * @param { Event } event
     *
     * @return { void }
     */
    _changeHandler(event)
    {
        this.customEvents.execute('event:' + event.type, event);
    }

    /**
     * Creates a new dom element.
     *
     * @abstract
     *
     * @protected
     *
     * @return { HTMLElement }
     */
    _createDomElement() {}

    /**
     * Create a dom label.
     *
     * @protected
     *
     * @return { HTMLLabelElement }
     */
    _createDomLabel()
    {
        return createHtmlElement('label', { class: this._settings.domLabelClassName, for: this._settings.id }, [ new Text(this._settings.label) ]);
    }

    /**
     * Create a dom label.
     *
     * @protected
     *
     * @return { HTMLDivElement }
     */
    _createDomOuter()
    {
        return createHtmlElement('div', { class: this._settings.domOuterClassName }, [ this._domLabel, this._domElement ]);
    }

    /**
     * Gets the dom element.
     *
     * @public
     *
     * @return { HTMLInputElement }
     */
    getDomElement()
    {
        return this._domElement;
    }

    /**
     * Gets the dom outer.
     *
     * @public
     *
     * @return { HTMLDivElement }
     */
    getDomOuter()
    {
        return this._domOuter;
    }

    /**
     * Gets ignored settings for attributes.
     *
     * @public
     *
     * @return { Array<string> }
     */
    getIgnoredSettings()
    {
        return [ 'domElement', 'domElementClassName', 'domLabelClassName', 'domOuterClassName', 'label', 'type' ];
    }

    /**
     * Clears the value.
     *
     * @public
     *
     * @return { void }
     */
    clear()
    {
        this._domElement.value = '';
    }

    /**
     * Gets the value.
     *
     * @public
     *
     * @return { any }
     */
    getValue()
    {
        return this._domElement.value;
    }

    /**
     * Gets the id.
     *
     * @public
     *
     * @return { string }
     */
    getId()
    {
        return this._settings.id;
    }

    /**
     * Gets the name.
     *
     * @public
     *
     * @return { string }
     */
    getName()
    {
        return this._settings.name;
    }

    /**
     * Gets the type.
     *
     * @public
     *
     * @return { InputType }
     */
    getType()
    {
        return this._settings.type;
    }

    /**
     * Switches the disabled state by the specified force.
     *
     * @public
     *
     * @param { boolean } force
     *
     * @return { void }
     */
    disabled(force)
    {
        this._domElement.disabled = force;
    }
}
