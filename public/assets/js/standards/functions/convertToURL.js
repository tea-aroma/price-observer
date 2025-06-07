/**
 * Converts the given url to URL.
 *
 * @param { string } url
 *
 * @return { URL }
 */
export function convertToURL(url)
{
    if (!/^https?:\/\//.test(url))
    {
        url = location.origin + '/' + url;
    }

    return new URL(url);
}
