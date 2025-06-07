/**
 * Creates a HTMLElement by the specified arguments.
 *
 * @param { keyof HTMLElementTagNameMap } tagName
 *
 * @param { Object } attributes
 *
 * @param { Array<Element | Text> } children
 *
 * @return { HTMLElement }
 */
export function createHtmlElement(tagName, attributes = {}, children = [])
{
    const element = document.createElement(tagName);

    for (const key in attributes)
    {
        element.setAttribute(key, attributes[ key ]);
    }

    element.append(...children);

    return element;
}
