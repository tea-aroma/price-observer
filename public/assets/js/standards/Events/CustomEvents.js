/**
 * Provides help working for custom events.
 **/
export class CustomEvents
{
    /**
     * @typedef { Object } CustomEventSettings
     *
     * @property { boolean ? } isOnce
     *
     * @property { boolean ? } isChain
     **/

    /**
     * @typedef { Map<Function, CustomEventSettings> } CustomEventType
     **/

    /**
     * @protected
     *
     * @type { Object<CustomEventType> }
     **/
    _events = {};

    /**
     * Creates a new type.
     *
     * @protected
     *
     * @param { string } type
     *
     * @return { void }
     **/
    _createType(type)
    {
        this._events[type] = new Map();
    }

    /**
     * Creates a new event handler.
     *
     * @protected
     *
     * @param { string } type
     *
     * @param { Function } handler
     *
     * @param { CustomEventSettings } settings
     *
     * @return { void }
     **/
    _createHandler(type, handler, settings)
    {
        this.getHandlersByType(type).set(handler, settings);
    }

    /**
     * Deletes an event handler.
     *
     * @protected
     *
     * @param { string } type
     *
     * @param { Function } handler
     *
     * @return { boolean }
     **/
    _deleteHandler(type, handler)
    {
        return this.getHandlersByType(type).delete(handler);
    }

    /**
     * Subscribes to an event by type.
     *
     * @public
     *
     * @param { string } type
     *
     * @param { Function } handler
     *
     * @param { CustomEventSettings } settings
     *
     * @return { CustomEvents }
     **/
    subscribe(type, handler, settings = {})
    {
        if (!this.hasType(type))
        {
            this._createType(type);
        }

        this._createHandler(type, handler, settings);

        return this;
    }

    /**
     * Unsubscribes to an event by type.
     *
     * @public
     *
     * @param { string } type
     *
     * @param { Function } handler
     *
     * @return { boolean }
     **/
    unsubscribe(type, handler)
    {
        if (this.hasType(type))
        {
            return this._deleteHandler(type, handler);
        }

        return false;
    }

    /**
     * Executes all event handlers by given type.
     *
     * @public
     *
     * @param { string } type
     *
     * @param { ...any } args
     *
     * @return { void }
     **/
    execute(type, ...args)
    {
        if (!this.hasType(type))
        {
            return ;
        }

        for (const [ handler, settings ] of this.getHandlersByType(type))
        {
            const result = handler(...args);

            if (settings.isOnce)
            {
                this.unsubscribe(type, handler);
            }

            if (settings.isChain && !result)
            {
                break ;
            }
        }
    }

    /**
     * Determines whether a given event type exists.
     *
     * @public
     *
     * @param { string } type
     *
     * @return { boolean }
     **/
    hasType(type)
    {
        return !!this._events[type];
    }

    /**
     * Gets all event handlers for the given type.
     *
     * @public
     *
     * @param { string } type
     *
     * @return { CustomEventType }
     **/
    getHandlersByType(type)
    {
        return this._events[type];
    }
}
