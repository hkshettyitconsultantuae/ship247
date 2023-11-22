import React from 'react';

const Context = React.createContext({
    _setState: (name, val) => { },
    state: {}
});

export default Context;