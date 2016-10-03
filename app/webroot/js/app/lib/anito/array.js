(function() {
  var __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  Array.prototype.toID = function() {
    var id, item, res, _i, _len;
    res = [];
    for (_i = 0, _len = this.length; _i < _len; _i++) {
      item = this[_i];
      id = typeof item === 'object' ? item.id : typeof item === 'string' ? item : void 0;
      if (id) {
        res.push(id);
      }
    }
    return res;
  };

  Array.prototype.removeFromList = function(list) {
    var id, idx, seq, _i, _j, _len, _len1;
    if (list == null) {
      list = [];
    }
    seq = [];
    for (idx = _i = 0, _len = this.length; _i < _len; idx = ++_i) {
      id = this[idx];
      if (__indexOf.call(list, id) >= 0) {
        seq.push(idx);
      }
    }
    seq.reverse();
    for (_j = 0, _len1 = seq.length; _j < _len1; _j++) {
      id = seq[_j];
      this.splice(id, 1);
    }
    return this;
  };

  Array.prototype.last = function() {
    var lastIndex;
    lastIndex = this.length - 1;
    return this[lastIndex] || null;
  };

  Array.prototype.first = function() {
    return this[0] || null;
  };

  Array.prototype.update = function(value) {
    if (Object.prototype.toString.call(value) !== '[object Array]') {
      throw new Error('passed value requires an array');
    }
    [].splice.apply(this, [0, this.length - 0].concat(value)), value;
    return this;
  };

  Array.prototype.addRemoveSelection = function(id) {
    this.toggleSelected(id);
    return this;
  };

  Array.prototype.add = function(id) {
    this.toggleSelected(id, true);
    return this;
  };

  Array.prototype.toggleSelected = function(id, addonly) {
    var index;
    if (!id) {
      return this;
    }
    if (__indexOf.call(this, id) < 0) {
      this.unshift(id);
    } else if (!addonly) {
      index = this.indexOf(id);
      if (index !== -1) {
        this.splice(index, 1);
      }
    }
    return this;
  };

  Array.prototype.contains = function(string) {
    var Regex, value, _i, _len;
    for (_i = 0, _len = this.length; _i < _len; _i++) {
      value = this[_i];
      Regex = new RegExp(value);
      if (Regex.test(string)) {
        return true;
      }
    }
  };

}).call(this);
