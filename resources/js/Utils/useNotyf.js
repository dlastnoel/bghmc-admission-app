import { Notyf } from 'notyf';

const notyf = new Notyf({
  duration: 3000,
  position: {
    x: 'right',
    y: 'bottom',
  },
  types: [
    {
      type: 'error',
      background: '#E57373',
      dismissible: false,
    },
    {
      type: 'info',
      background: '#1976D2',
      dismissible: false,
    }
  ]
})

export default {
  toast: (message, type = 'info') => {
    notyf.open({
      type: type,
      message: message
    })
  },
}