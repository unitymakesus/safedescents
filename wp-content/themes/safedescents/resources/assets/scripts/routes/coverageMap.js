import tippy from 'tippy.js'

export default {
  init() {
    console.log('test');

    tippy('.map path', {
      arrow: true,
      trigger: 'click',
      html: '#tooltip',
      theme: 'map',
    })
  },
};
