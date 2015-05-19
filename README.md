# elgentos RelatedBundles 

This extension creates a new product relation type, Related Bundles. This way, you can show related bundles separate from cross sells, up sells and normal related products. Only bundles will show up in the grid in the backend. As an added bonus, there is an observer added that, upon saving a Bundled product, will set said bundled product as a 'Related Bundle' for the simple products the bundled product is comprised of.

On the frontend, you can use the ```$product->getRelatedBundleCollection()``` method to fetch the Related Bundles and show them in your preferred manner. No frontend templates are provided as of now.
