import {Notify} from 'quasar'

export function notify_p(message) {
  Notify.create({
    message: `${message}`,
    type: 'positive',
  })
}

export function notify_n(message) {
  Notify.create({
    message: `${message} `,
    type: 'negative',
  })
}

