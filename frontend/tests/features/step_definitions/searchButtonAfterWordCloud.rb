When /^I input an artist$/ do
    find('#automplete-1').text.should_not eq ''
end
