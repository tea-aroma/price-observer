/**
 * Provides help working for data properties.
 */
export class Data
{
    /**
     * Creates instance by the specified values.
     *
     * @abstract
     *
     * @public
     *
     * @param { Array | Object } values
     *
     * @return { Data }
     */
    static fromValues(values) {};

    /**
     * Fills the instance by the specified values.
     *
     * @public
     *
     * @param { Array | Object } values
     *
     * @return { void }
     */
    fill(values)
    {
        for (const key in values)
        {
            const value = values[ key ];

            if (!this.hasOwnProperty(key))
            {
                continue;
            }

            this[ key ] = value;
        }
    }
}
