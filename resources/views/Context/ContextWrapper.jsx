import React, { Component } from 'react';
import Context from './AppContext';

class ContextWrapper extends Component {
    state = {}

    _setState = (name, val) => {
        this.setState({
            [name]: [val]
        })
    }

    render() {
        return (
            <Context.Provider
                value={{
                    _setState: this._setState,
                    state: this.state
                }}>
                {this.props.children}
            </Context.Provider>
        );
    }
}

export default ContextWrapper;