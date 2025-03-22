(function (blocks, element, blockEditor) {
    var el = element.createElement;
    var InspectorControls = blockEditor.InspectorControls;
    var TextControl = wp.components.TextControl;

    blocks.registerBlockType('wisus/custom-block', {
        title: 'Wisus Blog Block',
        icon: 'admin-post',
        category: 'widgets',

        attributes: {
            postsPerPage: {
                type: 'number',
                default: 6
            },
            columns: {
                type: 'number',
                default: 3
            }
        },

        edit: function (props) {
            var attributes = props.attributes;

            return el(
                'div',
                { className: 'custom-blog-block' },
                el(
                    InspectorControls,
                    null,
                    el(
                        'div',
                        { className: 'components-panel__body is-opened' },
                        el(TextControl, {
                            label: 'Number of posts to show',
                            value: attributes.postsPerPage,
                            onChange: function (value) {
                                props.setAttributes({ postsPerPage: parseInt(value) });
                            },
                            type: 'number'
                        }),
                        el(TextControl, {
                            label: 'Columns',
                            value: attributes.columns,
                            onChange: function (value) {
                                props.setAttributes({ columns: parseInt(value) });
                            },
                            type: 'number'
                        })
                    )
                ),
                el(
                    'p',
                    null,
                    'Displaying ', attributes.postsPerPage, ' posts in ', attributes.columns, ' columns'
                )
            );
        },
        save: function () {
            return null; // Renderizado en el servidor
        },
    });
})

(window.wp.blocks, window.wp.element, window.wp.blockEditor);