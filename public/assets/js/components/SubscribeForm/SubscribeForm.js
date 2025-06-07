import { Form } from '../Forms/Form.js';
import { InputType } from '../Inputs/InputType.js';
import { FormEvent } from '../Forms/FormEvent.js';
import { HttpRequest } from '../../standards/Requests/HttpRequest.js';
import { createHtmlElement } from '../../standards/functions/createHtmlElement.js';


/**
 * Provides logic for the Subscribe process.
 */
export class SubscribeForm
{
    /**
     * @public
     *
     * @type { Form }
     */
    form;

    /**
     * Initializes the base logic.
     *
     * @public
     *
     * @return { void }
     */
    async initialization()
    {
        this.form = new Form(this._getFormSettings());

        this.form.initialization();

        this.form.customEvents.subscribe(FormEvent.SUBMIT, this._submitHandler.bind(this));

        document.querySelector('main').append(this.form.getDomElement());
    }

    /**
     * Handles the 'submit' event.
     *
     * @protected
     *
     * @param { PointerEvent } event
     *
     * @return { void }
     */
    async _submitHandler(event)
    {
        const request = await this._request();

        if (!request.isSuccess())
        {
            this.form.setMessages(request.getResponse().errors, 'error');

            return;
        }

        this.form.setMessages({ message: [ request.getResponse().message ] }, 'success');

        this.form.clear();
    }

    /**
     * Handles the process of errors.
     *
     * @protected
     *
     * @return { void }
     */
    _errorProcessing(request)
    {
        const errorSpans = this._errorsToSpans(request.getResponse().errors);

        this.form.setMessages();
    }

    /**
     * Implements a request to the server.
     *
     * @protected
     *
     * @return { Promise<HttpRequest> }
     */
    async _request()
    {
        return await HttpRequest.send({ url: 'recipient/subscribe', method: 'post', data: this.form.toObject() });
    }

    /**
     * Converts errors to string.
     *
     * @protected
     *
     * @param { Object<string, Array<string>> } errors
     *
     * @return { DocumentFragment<HTMLSpanElement> }
     */
    _errorsToSpans(errors)
    {
        const fragment = document.createDocumentFragment();

        for (const key in errors)
        {
            const error = errors[key];

            for (let i = 0, n = error.length; i < n; i++)
            {
                const message = error[i];

                const span = createHtmlElement('span', {}, [ new Text(message) ]);

                fragment.append(span);
            }
        }

        return fragment;
    }

    /**
     * Gets the settings for Form component.
     *
     * @protected
     *
     * @return { FormSettingInterface }
     */
    _getFormSettings()
    {
        return {
            items:
                [
                    {
                        id: 'url',
                        name: 'url',
                        type: InputType.TEXT,
                        placeholder: '...',
                        label: 'Url',
                    },
                    {
                        id: 'email',
                        name: 'email',
                        type: InputType.TEXT,
                        placeholder: '...',
                        label: 'Email',
                    },
                ],
        };
    }

    /**
     * Gets a form item by the specified id.
     *
     * @public
     *
     * @return { TextInput }
     */
    formItem(id)
    {
        return this.form.getItem(id);
    }
}
